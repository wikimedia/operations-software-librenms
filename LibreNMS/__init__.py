import threading

from logging import critical, info, debug, exception
from math import ceil
from time import time

from .service import Service, ServiceConfig
from .queuemanager import QueueManager, TimedQueueManager, BillingQueueManager


def normalize_wait(seconds):
    return ceil(seconds - (time() % seconds))


class DB:
    def __init__(self, config, auto_connect=True):
        """
        Simple DB wrapper
        :param config: The poller config object
        """
        self.config = config
        self._db = {}

        if auto_connect:
            self.connect()

    def connect(self):
        try:
            import pymysql
            pymysql.install_as_MySQLdb()
            info("Using pure python SQL client")
        except ImportError:
            info("Using other SQL client")

        try:
            import MySQLdb
        except ImportError:
            critical("ERROR: missing a mysql python module")
            critical("Install either 'PyMySQL' or 'mysqlclient' from your OS software repository or from PyPI")
            raise

        try:
            args = {
                'host': self.config.db_host,
                'port': self.config.db_port,
                'user': self.config.db_user,
                'passwd': self.config.db_pass,
                'db': self.config.db_name
            }
            if self.config.db_socket:
                args['unix_socket'] = self.config.db_socket

            conn = MySQLdb.connect(**args)
            conn.autocommit(True)
            conn.ping(True)
            self._db[threading.get_ident()] = conn
        except Exception as e:
            critical("ERROR: Could not connect to MySQL database! {}".format(e))
            raise

    def db_conn(self):
        """
        Refers to a database connection via thread identifier
        :return: database connection handle
        """

        # Does a connection exist for this thread
        if threading.get_ident() not in self._db.keys():
            self.connect()

        return self._db[threading.get_ident()]

    def query(self, query, args=None):
        """
        Open a cursor, fetch the query with args, close the cursor and return it.
        :rtype: MySQLdb.Cursor
        :param query:
        :param args:
        :return: the cursor with results
        """
        cursor = self.db_conn().cursor()
        cursor.execute(query, args)
        cursor.close()
        return cursor


class RecurringTimer:
    def __init__(self, duration, target, thread_name=None):
        self.duration = duration
        self.target = target
        self._timer_thread = None
        self._thread_name = thread_name
        self._event = threading.Event()

    def _loop(self):
        while not self._event.is_set():
            self._event.wait(normalize_wait(self.duration))
            if not self._event.is_set():
                self.target()

    def start(self):
        self._timer_thread = threading.Thread(target=self._loop)
        if self._thread_name:
            self._timer_thread.name = self._thread_name
        self._event.clear()
        self._timer_thread.start()

    def stop(self):
        self._event.set()


class Lock:
    """ Base lock class this is not thread safe"""

    def __init__(self):
        self._locks = {}  # store a tuple (owner, expiration)

    def lock(self, name, owner, expiration, allow_owner_relock=False):
        """
        Obtain the named lock.
        :param allow_owner_relock:
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        :param expiration: int in seconds
        """
        if (
            (name not in self._locks) or                                          # lock doesn't exist
            (allow_owner_relock and self._locks.get(name, [None])[0] == owner) or  # owner has permission
            time() > self._locks[name][1]                                          # lock has expired
        ):
            self._locks[name] = (owner, expiration + time())
            return self._locks[name][0] == owner

        return False

    def unlock(self, name, owner):
        """
        Release the named lock.
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        """
        if (name in self._locks) and self._locks[name][0] == owner:
            self._locks.pop(name, None)
            return True
        return False

    def check_lock(self, name):
        lock = self._locks.get(name, None)
        if lock:
            return lock[1] > time()
        return False

    def print_locks(self):
        debug(self._locks)


class ThreadingLock(Lock):
    """A subclass of Lock that uses thread-safe locking"""

    def __init__(self):
        Lock.__init__(self)
        self._lock = threading.Lock()

    def lock(self, name, owner, expiration, allow_owner_relock=False):
        """
        Obtain the named lock.
        :param allow_owner_relock:
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        :param expiration: int in seconds
        """
        with self._lock:
            return Lock.lock(self, name, owner, expiration, allow_owner_relock)

    def unlock(self, name, owner):
        """
        Release the named lock.
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        """
        with self._lock:
            return Lock.unlock(self, name, owner)

    def check_lock(self, name):
        return Lock.check_lock(self, name)

    def print_locks(self):
            Lock.print_locks(self)


class RedisLock(Lock):
    def __init__(self, namespace='lock', **redis_kwargs):
        import redis
        redis_kwargs['decode_responses'] = True
        self._redis = redis.Redis(**redis_kwargs)
        self._redis.ping()
        self._namespace = namespace

    def __key(self, name):
        return "{}:{}".format(self._namespace, name)

    def lock(self, name, owner, expiration=1, allow_owner_relock=False):
        """
        Obtain the named lock.
        :param allow_owner_relock: bool
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        :param expiration: int in seconds, 0 expiration means forever
        """
        import redis

        try:
            if int(expiration) < 1:
                expiration = 1

            key = self.__key(name)
            non_existing = not (allow_owner_relock and self._redis.get(key) == owner)
            return self._redis.set(key, owner, ex=int(expiration), nx=non_existing)
        except redis.exceptions.ResponseError as e:
            exception("Unable to obtain lock, local state: name: %s, owner: %s, expiration: %s, allow_owner_relock: %s",
                      name, owner, expiration, allow_owner_relock)


    def unlock(self, name, owner):
        """
        Release the named lock.
        :param name: str the name of the lock
        :param owner: str a unique name for the locking node
        """
        key = self.__key(name)
        if self._redis.get(key) == owner:
            self._redis.delete(key)
            return True
        return False

    def check_lock(self, name):
        return self._redis.get(self.__key(name)) is not None

    def print_locks(self):
        keys = self._redis.keys(self.__key('*'))
        for key in keys:
            print("{} locked by {}, expires in {} seconds".format(key, self._redis.get(key), self._redis.ttl(key)))


class RedisQueue(object):
    def __init__(self, name, namespace='queue', **redis_kwargs):
        import redis
        redis_kwargs['decode_responses'] = True
        self._redis = redis.Redis(**redis_kwargs)
        self._redis.ping()
        self.key = "{}:{}".format(namespace, name)

    def qsize(self):
        return self._redis.llen(self.key)

    def empty(self):
        return self.qsize() == 0

    def put(self, item):
        # commented code allows unique entries, but shuffles the queue
        # p = self._redis.pipeline()
        # p.lrem(self.key, 1, item)
        # p.lpush(self.key, item)
        # p.execute()
        self._redis.rpush(self.key, item)

    def get(self, block=True, timeout=None):
        if block:
            item = self._redis.blpop(self.key, timeout=timeout)
        else:
            item = self._redis.lpop(self.key)

        if item:
            item = item[1]
        return item

    def get_nowait(self):
        return self.get(False)

source: General/Updating.md

By default, LibreNMS is set to automatically update. If you have disabled this feature then you can 
perform a manual update.

#### Manual update

If you would like to perform a manual update then you can do this by running the following command 
as the `librenms` user:

`./daily.sh`

This will update both the core LibreNMS files but also update the database
structure if updates are available.

#### Advanced users
If you absolutely must update manually without using `./daily.sh` then you can do so by running the following commands:
```bash
cd /opt/librenms
git pull
php includes/sql-schema/update.php
```

## Disabling automatic updates ##
LibreNMS by default performs updates on a daily basis. This can be disabled by setting:

`$config['update'] = 0;`

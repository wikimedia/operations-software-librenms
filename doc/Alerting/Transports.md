source: Alerting/Transports.md

# Transports

Transports are located within `LibreNMS/Alert/Transport/` and can be configured within the WebUI under Alerts -> Alert Transports.

Contacts will be gathered automatically and passed to the configured transports.
By default the Contacts will be only gathered when the alert triggers and will ignore future changes in contacts for the incident.
If you want contacts to be re-gathered before each dispatch, please set 'Updates to contact email addresses not honored' to Off in the WebUI.

The contacts will always include the `SysContact` defined in the Device's SNMP configuration and also every LibreNMS user that has at least `read`-permissions on the entity that is to be alerted.

At the moment LibreNMS only supports Port or Device permissions.

You can exclude the `SysContact` by toggling 'Issue alerts to sysContact'.

To include users that have `Global-Read`, `Administrator` or `Normal-User` permissions it is required to toggle the options:

  - Issue alerts to admins.
  - Issue alerts to read only users
  - Issue alerts to normal users.

## Using a Proxy?
[Proxy Configuration](../Support/Configuration.md#proxy-support)

## API
API transports definitions are a bit more complex than the E-Mail configuration.

The URL can have the same placeholders as defined in the [Template-Syntax](Templates#syntax).

If the `Api Method` is `get`, all placeholders will be URL-Encoded.

The API transport uses cURL to call the APIs, therefore you might need to install `php curl` to make it work.

__Note__: it is highly recommended to define your own [Templates](Templates) when you want to use the API transport. The default template might exceed URL-length for GET requests and therefore cause all sorts of errors.

**Example:**

| Config | Example |
| ------ | ------- |
| API Method | get |
| API URL    | http://my.example.com/api |

## Boxcar
Copy your access token from the Boxcar app or from the Boxcar.io website and setup the transport.

[Boxcar Docs](http://developer.boxcar.io/api/publisher/)

**Example:**

| Config | Example |
| ------ | ------- |
| Access Token | i23f23mr23rwerw |

## Canopsis
Canopsis is a hypervision tool. LibreNMS can send alerts to Canopsis which are then converted to canopsis events. 

[Canopsis Docs](http://www.canopsis.org/wp-content/themes/canopsis/doc/sakura/user-guide/event-spec.html)

**Example:**

| Config | Example |
| ------ | ------- |
| Hostname | www.xxx.yyy.zzz |
| Port Number | 5672 |
| User | admin |
| Password | my_password |
| Vhost | canopsis | 

## Cisco Spark
Cisco Spark. LibreNMS can send alerts to a Cisco Spark room. To make this possible you need to have a RoomID and a token. 

For more information about Cisco Spark RoomID and token, take a look here :

  - [Getting started](https://developer.ciscospark.com/getting-started.html)
  - [Rooms](https://developer.ciscospark.com/resource-rooms.html)

**Example:**

| Config | Example |
| ------ | ------- |
| API Token | ASd23r23edewda |
| RoomID | 34243243251 |

## Clickatell
Clickatell provides a REST-API requiring an Authorization-Token and at least one Cellphone number.

[Clickatell Docs](https://www.clickatell.com/developers/api-documentation/rest-api-request-parameters/)

Here an example using 3 numbers, any amount of numbers is supported:

**Example:**

| Config | Example |
| ------ | ------- |
| Token | dsaWd3rewdwea |
| Mobile Numbers | +1234567890,+1234567891,+1234567892 |

## Discord
The Discord transport will POST the alert message to your Discord Incoming WebHook. Simple html tags are stripped from 
the message. 

The only required value is for url, without this no call to Discord will be made. The Options field supports the
JSON/Form Params listed in the Discord Docs below.

[Discord Docs](https://discordapp.com/developers/docs/resources/webhook#execute-webhook)

**Example:**

| Config | Example |
| ------ | ------- |
| Discord URL | https://discordapp.com/api/webhooks/4515489001665127664/82-sf4385ysuhfn34u2fhfsdePGLrg8K7cP9wl553Fg6OlZuuxJGaa1d54fe |
| Options | username=myname |

## Elasticsearch
You can have LibreNMS send alerts to an elasticsearch database. Each fault will be sent as a separate document.

The index pattern uses strftime() formatting.

**Example:**

| Config | Example |
| ------ | ------- |
| Host | 127.0.0.1 |
| Port | 9200 |
| Index Patter | librenms-%Y.%m.%d |

## Gitlab
LibreNMS will create issues for warning and critical level alerts however only title and description are set. 
Uses Personal access tokens to authenticate with Gitlab and will store the token in cleartext.

**Example:**

| Config | Example |
| ------ | ------- |
| Host | http://gitlab.host.tld |
| Project ID | 1 |
| Personal Access Token | AbCdEf12345 |

## HipChat
See the HipChat API Documentation for [rooms/message](https://www.hipchat.com/docs/api/method/rooms/message)
for details on acceptable values.

> You may notice that the link points at the "deprecated" v1 API.  This is
> because the v2 API is still in beta.

**Example:**

| Config | Example |
| ------ | ------- |
| API URL | https://api.hipchat.com/v1/rooms/message?auth_token=109jawregoaihj |
| Room ID | 7654321 |
| From Name | LibreNMS |
| Options | color = red |
|  | notify = 1 |
|  | message_format = text |

At present the following options are supported: `color`, `notify` and `message_format`. 

> Note: The default message format for HipChat messages is HTML.  It is
> recommended that you specify the `text` message format to prevent unexpected
> results, such as HipChat attempting to interpret angled brackets (`<` and
> `>`).

## IRC
The IRC transports only works together with the LibreNMS IRC-Bot.
Configuration of the LibreNMS IRC-Bot is described [here](https://github.com/librenms/librenms/blob/master/doc/Extensions/IRC-Bot.md).

**Example:**

| Config | Example |
| ------ | ------- |
| IRC | enabled |

## JIRA
You can have LibreNMS create issues on a Jira instance for critical and warning alerts. The Jira transport only sets 
summary and description fields. Therefore your Jira project must not have any other mandatory field for the provided 
issuetype. The config fields that need to set are Jira URL, Jira username, Jira password, Project key, and issue type. 
Currently http authentication is used to access Jira and Jira username and password will be stored as cleartext in the 
LibreNMS database.

[Jira Issue Types](https://confluence.atlassian.com/adminjiracloud/issue-types-844500742.html)

**Example:**

| Config | Example |
| ------ | ------- |
| URL | https://myjira.mysite.com |
| Project Key | JIRAPROJECTKEY | 
| Issue Type | Myissuetype |
| Jira Username | myjirauser |
| Jira Password | myjirapass |

## Mail
For all but the default contact, we support setting multiple email addresses separated by a comma. So you can 
set the devices sysContact, override the sysContact or have your users emails set like:

`email@domain.com, alerting@domain.com`

The E-Mail transports uses the same email-configuration like the rest of LibreNMS.
As a small reminder, here is it's configuration directives including defaults:

**Example:**

| Config | Example |
| ------ | ------- |
| Email | me@example.com |

## Microsoft Teams
Microsoft Teams. LibreNMS can send alerts to Microsoft Teams Connector API which are then posted to a specific channel. 

**Example:**

| Config | Example |
| ------ | ------- |
| WebHook URL | https://outlook.office365.com/webhook/123456789 |

## Nagios Compatible
The nagios transport will feed a FIFO at the defined location with the same format that nagios would.
This allows you to use other alerting systems with LibreNMS, for example [Flapjack](http://flapjack.io).

**Example:**

| Config | Example |
| ------ | ------- |
| Nagios FIFO | /path/to/my.fifo |

## OpsGenie
Using OpsGenie LibreNMS integration, LibreNMS forwards alerts to OpsGenie with detailed information.
OpsGenie acts as a dispatcher for LibreNMS alerts, determines the right people to notify based on on-call 
schedules and notifies via email, text messages (SMS), phone calls and iOS & Android push notifications.
Then escalates alerts until the alert is acknowledged or closed.

Create a [LibreNMS Integration](https://docs.opsgenie.com/docs/librenms-integration) from the integrations page 
once you signup. Then copy the API key from OpsGenie to LibreNMS.

If you want to automatically ack and close alerts, leverage Marid integration. More detail with screenshots is 
available in [OpsGenie LibreNMS Integration page](https://docs.opsgenie.com/docs/librenms-integration).

**Example:**

| Config | Example |
| ------ | ------- |
| WebHook URL | https://url/path/to/webhook |

## osTicket
LibreNMS can send alerts to osTicket API which are then converted to osTicket tickets. 

**Example:**

| Config | Example |
| ------ | ------- |
| API URL | http://osticket.example.com/api/http.php/tickets.json |
| API Token | 123456789 |

## PagerDuty
LibreNMS can make use of PagerDuty, this is done by utilizing an API key and Integraton Key.

API Keys can be found under 'API Access' in the PagerDuty portal.

Integration Keys can be found under 'Integration' for the particular Service you have created in the PagerDuty portal.

**Example:**

| Config | Example |
| ------ | ------- |
| API Key | randomsample |
| Integration Key | somerandomstring |

## Philips Hue
Want to spice up your noc life? LibreNMS will flash all lights connected to your philips hue bridge whenever an alert is triggered. 

To setup, go to the you http://`your-bridge-ip`/debug/clip.html

- Update the "URL:" field to `/api`
- Paste this in the "Message Body" {"devicetype":"librenms"}
- Press the round button on your `philips Hue Bridge`
- Click on `POST`
- In the `Command Response` You should see output with your username. Copy this without the quotes

More Info: [Philips Hue Documentation](https://www.developers.meethue.com/documentation/getting-started)

**Example:**

| Config | Example |
| ------ | ------- |
| Host | http://your-bridge-ip |
| Hue User | username |
| Duration | 1 Second |

## PlaySMS
PlaySMS is an open source SMS-Gateway that can be used via their HTTP API using a Username and WebService Token.
Please consult PlaySMS's documentation regarding number formatting.

[PlaySMS Docs](https://github.com/antonraharja/playSMS/blob/master/documents/development/WEBSERVICES.md)

Here an example using 3 numbers, any amount of numbers is supported:

**Example:**

| Config | Example |
| ------ | ------- |
| PlaySMS | https://localhost/index.php?app=ws |
| User | user1 |
| Token | MYFANCYACCESSTOKEN |
| From | My Name |
| Mobiles | +1234567892,+1234567890,+1234567891 |

## Pushbullet
Get your Access Token from your Pushbullet's settings page and set it in your transport:

**Example:**

| Config | Example |
| ------ | ------- |
| Access Token | MYFANCYACCESSTOKEN |

## Pushover
If you want to change the [notification sounds](https://pushover.net/api#sounds) then add it in Pushover Options:

`sound_critical=falling`

Enabling Pushover support is fairly easy, there are only two required parameters.

Firstly you need to create a new Application (called LibreNMS, for example) in your account on the Pushover website (https://pushover.net/apps)

Now copy your API Key and obtain your User Key from the newly created Application and setup the transport.

[Pushover Docs](https://pushover.net/api)

**Example:**

| Config | Example |
| ------ | ------- |
| Api Key | APPLICATIONAPIKEYGOESHERE |
| User Key | USERKEYGOESHERE |
| Pushover Options | sound_critical=falling |

## Rocket.chat
The Rocket.chat transport will POST the alert message to your Rocket.chat Incoming WebHook using the
attachments option. Simple html tags are stripped from the message. All options are optional, the only
required value is for url, without this then no call to Rocket.chat will be made.

[Rocket.chat Docs](https://rocket.chat/docs/developer-guides/rest-api/chat/postmessage)

**Example:**

| Config | Example |
| ------ | ------- |
| Webhook URL | https://rocket.url/api/v1/chat.postMessage |
| Rocket.chat Options | channel=#Alerting |
|  | username=myname |
|  | icon_url=http://someurl/image.gif |
|  | icon_emoji=:smirk: |

## Slack
The Slack transport will POST the alert message to your Slack Incoming WebHook using the attachments option,
you are able to specify multiple webhooks along with the relevant options to go with it. Simple html tags 
are stripped from the message. All options are optional, the only required value is for url, without this 
then no call to Slack will be made.

We currently support the following attachment options:

`author_name`

[Slack docs](https://api.slack.com/docs/message-attachments)

**Example:**

| Config | Example |
| ------ | ------- |
| Webhook URL | https://slack.com/url/somehook |
| Slack Options | author_name=Me |

## SMSEagle
SMSEagle is a hardware SMS Gateway that can be used via their HTTP API using a Username and password.

Destination numbers are one per line, with no spaces. They can be in either local or international dialling format.

[SMSEagle Docs](http://www.smseagle.eu)

**Example:**

| Config | Example |
| ------ | ------- |
| SMSEagle URL | ip.add.re.ss |
| User | smseagle_user |
| Password | smseagle_user_password |
| Mobiles | +3534567890 |
|  | 0834567891 |

## Syslog
You can have LibreNMS emit alerts as syslogs complying with RFC 3164.

More information on RFC 3164 can be found here: https://tools.ietf.org/html/rfc3164

Example output: `<26> Mar 22 00:59:03 librenms.host.net librenms[233]: [Critical] network.device.net: Port Down - port_id => 98939; ifDescr => xe-1/1/0;`

Each fault will be sent as a separate syslog.

**Example:**

| Config | Example |
| ------ | ------- |
| Host | 127.0.0.1 |
| Port | 514 |
| Facility | 3 |

## Telegram
> Thank you to [snis](https://github.com/snis) for these instructions.

1. First you must create a telegram account and add BotFather to you list. To do this click on the following url: https://telegram.me/botfather

2. Generate a new bot with the command "/newbot" BotFather is then asking for a username and a normal name. After that your bot is created and you get a HTTP token. (for more options for your bot type "/help")

3. Add your bot to telegram with the following url: `http://telegram.me/<botname>` and send some text to the bot.

4. The BotFather should have responded with a token, copy your token code and go to the following page in chrome: `https://api.telegram.org/bot<tokencode>/getUpdates`
(this could take a while so continue to refresh until you see something similar to below)

5. You see a json code with the message you sent to the bot. Copy the Chat id. In this example that is “-9787468”
   `"message":{"message_id":7,"from":"id":656556,"first_name":"Joo","last_name":"Doo","username":"JohnDoo"},"chat":{"id":-9787468,"title":"Telegram Group"},"date":1435216924,"text":"Hi"}}]}`
   
6. Now create a new "Telegram transport" in LibreNMS (Global Settings -> Alerting Settings -> Telegram transport).
Click on 'Add Telegram config' and put your chat id and token into the relevant box.

[Telegram Docs](https://core.telegram.org/api)

**Example:**

| Config | Example |
| ------ | ------- |
| Chat ID | 34243432 |
| Token | 3ed32wwf235234 |

## VictorOps
VictorOps provide a webHook url to make integration extremely simple. To get the URL required login to your VictorOps 
account and go to:

Settings -> Integrations -> REST Endpoint -> Enable Integration.

The URL provided will have $routing_key at the end, you need to change this to something that is unique to the system 
sending the alerts such as librenms. I.e:

`https://alert.victorops.com/integrations/generic/20132414/alert/2f974ce1-08fc-4dg8-a4f4-9aee6cf35c98/librenms`

**Example:**

| Config | Example |
| ------ | ------- |
| Post URL | https://alert.victorops.com/integrations/generic/20132414/alert/2f974ce1-08fc-4dg8-a4f4-9aee6cf35c98/librenms |

## Kayako Classic

LibreNMS can send alerts to Kayako Classic API which are then converted to tickets. 
To use this module, you need REST API feature enabled in Kayako Classic and configured email account at LibreNMS. To enable this, do this:

AdminCP -> REST API -> Settings -> Enable API (Yes)

Also you need to know the department id to provide tickets to appropriate department and a user email to provide, which is used as ticket author. 
To get department id: navigate to appropriate department name at the departments list page in Admin CP and watch the number at the end of url. 
Example: http://servicedesk.example.com/admin/Base/Department/Edit/17. Department ID is 17

As a requirement, you have to know API Url, API Key and API Secret to connect to servicedesk

[Kayako REST API Docs] (https://classic.kayako.com/article/1502-kayako-rest-api)

**Example:**

| Config | Example |
| ------ | ------- |
| Kayako URL | http://servicedesk.example.com/api/ |
| Kayako API Key | 8cc02f38-7465-4a0c-8730-bb3af122167b |
| Kayako API Secret | Y2NhZDIxNDMtNjVkMi0wYzE0LWExYTUtZGUwMjJiZDI0ZWEzMmRhOGNiYWMtNTU2YS0yODk0LTA1MTEtN2VhN2YzYzgzZjk5 |
| Kayako Department | 1 |

## SMSFeedback

SMSFeedback is a SAAS service, which can be used to deliver Alerts via API, using API url, Username & Password.

They can be in international dialling format only.

[SMSFeedback Api Docs](https://www.smsfeedback.ru/smsapi/)

**Example:**

| Config | Example |
| ------ | ------- |
| User | smsfeedback_user |
| Password | smsfeedback_password |
| Mobiles | 71234567890 |
| Sender name| CIA |
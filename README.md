# CovidMaroc-Telegram-Bot
Receive latest coronavirus statistics in Morocco


## Installation

```bash
git clone https://github.com/NAYCHO334/CovidMaroc-Telegram-Bot.git
```

Use composer to install packages

```bash
cd CovidMaroc-Telegram-Bot

composer update
```

## Create a telegram bot
There's a… bot for that. Just talk to [BotFather ](https://t.me/botfather) and follow a few simple steps. Once you've created a bot and received your authorization token.


**Copy Token and paste it in:**

> /index.php   [line 30]

> /updater.php [line 37]


## Usage
Copy the project to a server. 
for example:
https://example.com/project/


Now you have to register your project's index.php page to telegram bot to redirect requests to your server.

Change <token> with your token, and project URL, then open the URL in a new page.
```https://api.telegram.org/bot<token>/setWebhook?url=https://example.com/project/index.php```

A result will return like this:
```bash {
"ok": true,
"result": true,
"description": "Webhook *******"
}
```

**Please Note:** *All queries to the Telegram Bot API must be served over HTTPS and need to be presented in this form: https://api.telegram.org/bot<token>/METHOD_NAME.*
[See Documentation](https://core.telegram.org/bots/api#available-methods)


## Cron job
To check new updates continuously just declare ```https://example.com/project/updater.php``` in your server's cron job.
If there's an update, a message will be sent to all subscribed users.


## CAUTION
When ```https://www.covidmaroc.ma/``` owners want to update data, they change dom also 🤣 so that may cause an error in the program 😕

## License
[MIT](https://choosealicense.com/licenses/mit/)

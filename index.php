<?php

require_once __DIR__ . "/vendor/autoload.php";

// Telegram Bot Handler
require_once __DIR__ . "/lib/telegramBot.php";

// Data Crawler from http://www.covidmaroc.ma/
require_once __DIR__ . "/lib/crawlData.php";

// Count Requests Per User
require_once __DIR__ . "/helpers/markVisit.php";

// File Saver
require_once __DIR__ . "/helpers/saveFile.php";

// New User Saver
require_once __DIR__ . "/helpers/subscribeUser.php";

// Message Template
require_once __DIR__ . "/helpers/newMessage.php";

$crawler = new CrawlData();

// Get Crawling results
$crawler->onSuccess(function ($coronaData) {

    // You must create a new bot in telegram
    // Follow these instuctions https://core.telegram.org/bots#3-how-do-i-create-a-bot
    $TOKEN = "";

    // Create Telegram bot instance
    $bot = new TelegramBot($TOKEN);

    // Get user info
    $chat_id = $bot->queries['message']['chat']['id'];

    $first_name = $bot->queries['message']['chat']['first_name'];
    $first_name = $first_name ? $first_name : "";

    $last_name = $bot->queries['message']['chat']['last_name'];
    $last_name = $last_name ? $last_name : "";

    $date = $bot->queries['message']['date'];

    // Check if user exists, or save it if not
    subscribeUser($chat_id, $first_name, $last_name, $date);

    // Count Number of request per every user
    markVisit($chat_id);

    // build a message
    $message = newMessage($coronaData, $first_name, $last_name, false);

    // Send Message to User
    $bot->sendMessage($chat_id, $message, "parse_mode=HTML");
});


$crawler->onError(function ($error) {
    echo $error;
});

$crawler->run();

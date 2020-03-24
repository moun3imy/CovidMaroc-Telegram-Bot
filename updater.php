<?php

require_once __DIR__ . "/vendor/autoload.php";

// Telegram Bot Handler
require_once __DIR__ . "/lib/telegramBot.php";

// Data Crawler from http://www.covidmaroc.ma/
require_once __DIR__ . "/lib/crawlData.php";

// File Saver
require_once __DIR__ . "/helpers/saveFile.php";

// New User Saver
require_once __DIR__ . "/helpers/subscribeUser.php";

// Message Template
require_once __DIR__ . "/helpers/newMessage.php";

// Function to compare last and new update time
require_once __DIR__ . "/helpers/compareUpdateTime.php";

$crawler = new CrawlData();

$crawler->onSuccess(function ($coronaData) {

    // Get List of Subscribed Users
    $list_of_users = json_decode(file_get_contents(__DIR__ . "/subscribers.json"), true);

    // Check last Update Time
    $lastUpdate = $coronaData['last_update'];

    // Check if there's a new update
    $newUpdate = compareUpdateTime($lastUpdate);

    if ($newUpdate) {
        $TOKEN = "";
        $bot = new TelegramBot($TOKEN);
        foreach ($list_of_users as $user) {

            // Get User data
            $chat_id = $user['chat_id'];

            $first_name = $user['first_name'];
            $first_name = $first_name ? $first_name : "";

            $last_name = $user['last_name'];
            $last_name = $last_name ? $last_name : "";

            // build a message
            $message = newMessage($coronaData, $first_name, $last_name, true);

            // send message to user
            $bot->sendMessage($chat_id, $message, "parse_mode=HTML");
        }
    } else echo "NO NEW UPDATES FOUND!";
});

$crawler->onError(function ($error) {
    echo $error;
});

$crawler->run();

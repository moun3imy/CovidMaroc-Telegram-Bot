<?php

function subscribeUser($chat_id, $first_name, $last_name, $date)
{
    $list_path = __DIR__ . "/../subscribers.json";

    // Create "subscribers.json" file if not exists
    $is_file_exists = file_exists($list_path);
    if (!$is_file_exists) saveFile($list_path, "{}");

    // Check if user exist
    $content = json_decode(file_get_contents($list_path), true);
    $userExists = array_key_exists($chat_id, $content);

    if (!$userExists) {
        $content[$chat_id] = [
            'chat_id' => $chat_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'visits' => 0,
            'date' => $date,
        ];
        saveFile($list_path, json_encode($content));
    }
}

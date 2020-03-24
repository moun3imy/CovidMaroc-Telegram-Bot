<?php

function markVisit($chat_id)
{
    $users_list_path = __DIR__ . "/../subscribers.json";
    $users = json_decode(file_get_contents($users_list_path), true);

    if (array_key_exists("visits", $users[$chat_id]))
        $users[$chat_id]['visits']++;
    else
        $users[$chat_id]['visits'] = 1;

    saveFile($users_list_path, json_encode($users));
}

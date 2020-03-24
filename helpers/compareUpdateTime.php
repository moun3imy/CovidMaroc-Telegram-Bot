<?php

function compareUpdateTime($newTime)
{

    // Old update time file
    $file_path = __DIR__ . "/../timeWatcher.txt";

    // Check if "timeWatcher.txt" exists, create a new one if doesn't
    if (!file_exists($file_path)) saveFile($file_path, "");

    // old update time
    $oldTime = file_get_contents(__DIR__ . "/../timeWatcher.txt");

    if ($newTime !== $oldTime) saveFile($file_path, $newTime);

    return $newTime !== $oldTime;
}

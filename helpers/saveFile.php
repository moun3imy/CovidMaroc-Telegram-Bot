<?php

function saveFile($path, $text)
{
    $file = fopen($path, "w");
    fwrite($file, $text);
    fclose($file);
}

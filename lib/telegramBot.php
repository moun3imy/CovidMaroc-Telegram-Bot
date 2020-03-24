<?php

class TelegramBot
{
    public $queries;
    public $webHook;

    public function __construct($token)
    {
        // Read queries data
        $content = file_get_contents("php://input");
        $queries = json_decode($content, true);
        
        $this->queries = $queries;
        $this->webHook = "https://api.telegram.org/bot$token";
    }
    public function sendMessage($chat_id, $message, $options = "")
    {
        try {
            $encodeMessage = urlencode($message);
            $url = $this->webHook . "/sendMessage?chat_id=$chat_id&text=$encodeMessage&$options";
            file_get_contents($url);
        } catch (Exception $error) {
            $this->handleError($error);
        }
    }
    public function handleError($error)
    {
        saveFile(__DIR__ . "/../errors_log/" . time() . ".txt", $error);
    }
}

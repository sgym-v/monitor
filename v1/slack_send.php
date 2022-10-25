<?php

function slack_send($text)
{
    $url = SLACK_HOOK_URL;
    $message = [
        "channel" => "#運用",
        "username" => "ロボット",
        "text" => "",
        "attachments" => [
            "blocks" => [
                "color" => "#86B049",
                "type" => "section",
                "text" => $text,
            ],
        ],
    ];
    $ch = curl_init();        
    $options = [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => http_build_query([
        'payload' => json_encode($message)
      ])
    ];
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);
}
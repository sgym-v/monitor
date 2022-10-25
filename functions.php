<?php

function send_slack($level, $message)
{
    $url = SLACK_NOTICE_URL;
    if($level == "warn")
    {
        $channel = "#警告";
    }
    else if($level == "debug")
    {
        $channel = "#定期実行";
    }
    $message = [
        "channel" => $channel,
        "username" => "すぎやまbot",
        "text" => "",
        "attachments" => [
            "blocks" => [
                "color" => "#86B049",
                "type" => "section",
                "text" => $message,
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
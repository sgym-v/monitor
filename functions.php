<?php

function send_slack($level, $message)
{
    $url = SLACK_URL;
    if($level == "warn")
    {
        $channel = SLACK_WARN_CHANNEL;
    }
    else if($level == "debug")
    {
        $channel = SLACK_DEBUG_CHANNEL;
    }
    $message = [
        "channel" => $channel,
        "username" => SLACK_BOT_NAME,
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

function send_mail($level, $message)
{
    $to = MAIL_TO;
    if($level == "warn")
    {
        $subject = MAIL_WARN_SUBJECT;
    }
    else if($level == "debug")
    {
        $subject = MAIL_DEBUG_SUBJECT;
    }
    $additional_headers = "From: ".MAIL_FROM."\r\nReply-To: ".MAIL_FROM."\r\n";
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    mb_send_mail($to, $subject, $message, $additional_headers);
}

function send($level, $message)
{
    $methods = SEND_METHODS;
    if($level == 'warn')
    {
        foreach($methods as $method)
        {
            if($method == 'mail_warn')
            {
                send_mail($level, $message);
            }
            elseif($method == 'slack_warn')
            {
                send_slack($level, $message);
            }
        }
    }
    elseif($level == 'debug')
    {
        foreach($methods as $method)
        {
            if($method == 'mail_debug')
            {
                send_mail($level, $message);
            }
            elseif($method == 'slack_debug')
            {
                send_slack($level, $message);
            }
        }
    }
}

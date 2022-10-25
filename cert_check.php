<?php
#************************************#
# 証明書チェックスクリプト            #
# 使用方法：                         #
# $ php cert_check.php [ドメイン名]  #
#************************************#
require_once "config.php";
require_once "functions.php";

#ドメイン
$domain = $argv[1];

#チェック処理
$stream_context = stream_context_create(array(
    'ssl' => array('capture_peer_cert' => true)
));
$resource = stream_socket_client(
    'ssl://' . $domain . ':443',
    $errno,
    $errstr,
    30,
    STREAM_CLIENT_CONNECT,
    $stream_context
);
$cont = stream_context_get_params($resource);
$parsed = openssl_x509_parse($cont['options']['ssl']['peer_certificate']);
if (strpos($parsed['subject']['CN'], $domain) !== false)
{
    #現在の日付
    $current_date = new DateTime();
    #有効期限日
    $limit_date = new DateTime(date('Y-m-d', $parsed['validTo_time_t']));
    #残り日数
    $day = $current_date->diff($limit_date);
    if($day->days <= 30)
    {
        $level = "warn";
        $slack_message = "<".SLACK_MEMBER_ID."> 【警告】証明書の有効期限が1カ月を切っています。\n
        ドメイン名：" . strval($domain) ."\n
        有効期限日：" . $limit_date->format('Y年m月d日') ."\n
        残り日数：" . $day->days . "日";
    }
    else
    {
        $level = "debug";
        $slack_message = $domain . "　証明書チェック\n
        ドメイン名：" . $domain ."\n
        有効期限日：" . $limit_date->format('Y年m月d日') ."\n
        残り日数：" . $day->days . "日";
    }
}
else
{
    $level = "warn";
    $slack_message = "<".SLACK_MEMBER_ID."> 【警告】証明書の取得に失敗しました。\n
    ドメイン名：" . $domain;
}
send_slack($level, $slack_message);

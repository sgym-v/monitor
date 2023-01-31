<?php
#*******************************#
# アクセスチェックスクリプト      #
# 使用方法：                     #
# $ php access_check.php [URL]  #
#*******************************#
require_once 'config.php';
require_once 'functions.php';

#URL
$url = $argv[1];

$context = stream_context_create(array(
    'http' => array('ignore_errors' => true)
));
$response = file_get_contents($url);
preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
$status_code = $matches[1];
switch ($status_code) {
    case '200':
        $level = 'debug';
        $message = $url . ' アクセスチェック OK';
        break;
    default:
        $level = 'warn';
        $message = SLACK_MEMBER_ID.' 【緊急】Webページにアクセスできません。\n
        URL：' . $url .'\n
        ステータスコード：' . $status_code;
        break;
}
send($level, $message);
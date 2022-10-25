<?php
#************************************#
# SSL有効期限通知システム             #
# 使い方:                            #
# $ php main.php [ドメイン名]        #
#************************************#
require_once "config.php";
require_once "ssl_expiration_check.php";
require_once "slack_send.php";
require_once "config.php";

$domain = $argv[1];
$date = ssl_expiration_check($domain);
$text = "SSL証明書の有効期限は【" . $date ."】です\n" . "URL：https://" . $domain;
slack_send($text);

# cd /home/www/server-check; php main.php yaidu-seodoa.com;
# cd /home/www/server-check; php main.php yaidu-sofia.com;
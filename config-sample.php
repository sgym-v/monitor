<?php
#送信オプション
define('SEND_OPTIONS', ['mail_warn', 'main_debug', 'slack_warn', 'slack_debug']);

#Slackの通知URL
define('SLACK_URL', '');

#Slackチャンネル名
define('SLACK_WARN_CHANNEL', '');
define('SLACK_DEBUG_CHANNEL', '');

#Slackボット名
define('SLACK_BOT_NAME', '');

#SlackのメンバーID
define('SLACK_MEMBER_ID', '<@xxxxxxx> <@xxxxxxx>');

#メール送信先
define('MAIL_TO', 'xxxxxxxxxxx@xxxxxxx.com');

#メール送信元
define('MAIL_FROM', 'xxxxxxxxxxx@xxxxxxx.com');

#メール件名
define('MAIL_WARN_SUBJECT', '');
define('MAIL_DEBUG_SUBJECT', '');

#ディスク使用率の上限
define('LIMIT_DISK_USED_RATE', 80);


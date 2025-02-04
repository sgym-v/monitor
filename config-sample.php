<?php
#*******************************#
# 全般的な設定                   #
#*******************************#
#ディスク使用率の閾値
define('LIMIT_DISK_USED_RATE', 80);
#送信方法
define('SEND_METHODS', ['mail_warn', 'main_debug', 'slack_warn', 'slack_debug']);

#*******************************#
# メールの設定                   #
#*******************************#
#送信先
define('MAIL_TO', 'xxxxxxxxxxx@xxxxxxx.com');
#送信元
define('MAIL_FROM', 'xxxxxxxxxxx@xxxxxxx.com');
#件名
define('MAIL_WARN_SUBJECT', '');
define('MAIL_DEBUG_SUBJECT', '');

#*******************************#
# Slackの設定                   #
#*******************************#
#通知URL
define('SLACK_URL', '');
#チャンネル名
define('SLACK_WARN_CHANNEL', '');
define('SLACK_DEBUG_CHANNEL', '');
#ボット名
define('SLACK_BOT_NAME', '');
#メンバーID
define('SLACK_MEMBER_ID', '<@xxxxxxx> <@xxxxxxx>');

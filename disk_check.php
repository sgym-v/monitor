<?php
#************************************************#
# ディスク容量チェックスクリプト                   #
# 使用方法：                                      #
# $ php disk_check.php [マウント名] [サーバー名]  #
#***********************************************#
require_once "config.php";
require_once "functions.php";

#マウント名
$mount = $argv[1];
$server = $argv[2];

exec ('df -H', $result, $status);
foreach ($result as $key => $value) {
    $value = preg_replace("/\bMounted on\b/i", "MountedOn", $value);
    $value = preg_replace("/\s+/", " ", $value);
    $data = explode(" ", $value);
    if($data[5] == $mount)
    {
        $size = $data[1];
        $used_size = $data[2];
        $avail_size = $data[3];
        $used_rate_tmp = $data[4];
        $used_rate = str_replace('%', '', $used_rate_tmp);
    }
}    
if($used_rate >= LIMIT_DISK_USED_RATE)
{
    $level = "warn";
    $slack_message = SLACK_MEMBER_ID . "【警告】ディスク使用率が".LIMIT_DISK_USED_RATE."%を超えています。\n
    サーバー名：" . $server ."\n
    パス：" . $mount ."\n
    容量：" . $size ."\n
    使用容量：" .  $used_size ."\n
    使用率：" . $used_rate ."%\n
    残り容量：" . $avail_size;
}
else
{
    $level = "debug";
    $slack_message = $server . " ディスク容量チェック\n
    サーバー名：" . $server ."\n
    パス：" . $mount ."\n
    容量：" . $size ."\n
    使用容量：" . $used_size ."\n
    使用率：" . $used_rate ."%\n
    残り容量：" . $avail_size;
}
send_slack($level, $slack_message);

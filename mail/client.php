<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);
$client->set(array(
    'open_length_check'     => true,
    'package_length_type'   => 'N',
    'package_length_offset' => 0,       //第N个字节是包长度的值
    'package_body_offset'   => 4,       //第几个字节开始计算长度
    'package_max_length'    => 2000000,  //协议最大长度
));
if (!$client->connect('127.0.0.1', 8996, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}

$sendStr = json_encode([
    'to'=>'31477177@qq.com',
    'title'=>'注册验证邮件',
    'content'=>'你此次验证码为：'.mt_rand(100000, 999999),
]);
$sendData = pack('N', strlen($sendStr)) . $sendStr;
$client->send($sendData);
echo substr($client->recv(), 4);
$client->close();

<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('127.0.0.1', 8996, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
$client->send(json_encode([
    'to'=>'31477177@qq.com',
    'title'=>'注册验证邮件',
    'content'=>'你此次验证码为：'.mt_rand(100000, 999999),
]));
echo $client->recv();
$client->close();

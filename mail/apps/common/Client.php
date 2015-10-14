<?php
/**
 * Created by PhpStorm.
 * User: shenzhe
 * Date: 15-10-12
 * Time: 下午9:07
 */

namespace common;


class Client
{

    private static $client;
    public static function init()
    {
        if(!self::$client) {
            $client = new swoole_client(SWOOLE_SOCK_TCP|SWOOLE_KEEP);
            if(!$client->isConnected()) {
                $client->set(array(
                    'open_length_check' => true,
                    'package_length_type' => 'N',
                    'package_length_offset' => 0,       //第N个字节是包长度的值
                    'package_body_offset' => 4,       //第几个字节开始计算长度
                    'package_max_length' => 2000000,  //协议最大长度
                ));
                if (!$client->connect('127.0.0.1', 8996, 1)) {
//                    throw new MyException('client connect timeout', ERROR::CONNECTION_TIMEOUT);
                    return false;
                }
            }
            self::$client = $client;
        }

        return self::$client;
    }


    public static function send($to, $title, $content)
    {
        $client = self::init();
        if(!$client) {
            return false;
        }
        $sendStr = json_encode([
            'to'=> $to,
            'title'=> $title,
            'content'=> $content,
        ]);
        $sendData = pack('N', strlen($sendStr)) . $sendStr;
        $client->send($sendData);
        return substr($client->recv(), 4);
    }
}
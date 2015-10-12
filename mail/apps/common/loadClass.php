<?php

namespace common;


use ZPHP\Core\Factory;

class loadClass
{
    /**
     * @param $service
     * @return \service\Base
     * @desc 获取service实例
     */
    public static function getService($service)
    {
        return Factory::getInstance("service\\{$service}");
    }

    /**
     * @return \PHPMailer\PHPMailer
     */
    public static function getPhpMail()
    {
        return Factory::getInstance("PHPMailer\\PHPMailer");
    }


}

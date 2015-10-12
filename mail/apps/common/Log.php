<?php

namespace common;

use ZPHP\Common\Log as ZLog;

/*
 * 获取配置
 */

class Log
{
    public static function info($data, $file = "info")
    {
        ZLog::info($file, $data);
    }
}

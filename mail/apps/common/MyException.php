<?php

namespace common;

use ZPHP\Core\Config as ZConfig;
use ZPHP\Protocol\Request;
use ZPHP\Protocol\Response;
use ZPHP\Common\Formater as ZFormater;

/**
 * 获取class实例的工具类
 *
 * @package service
 *
 */
class MyException extends \Exception
{
    private $realCode = '';

    /**
     * 执行过程中产生的所有异常
     *
     * @var Array
     */
    private static $exceptions = array();

    public function __construct($message, $code = 0)
    {
        $this->realCode = $code;
        parent::__construct($message, $code);
        self::$exceptions[] = $this;
    }

    /**
     * 获取执行过程中的异常发生次数
     *
     * @return int
     */
    public static function getExceptionNum()
    {
        return \count(self::$exceptions);
    }

    /**
     * 获取执行过程中的发生的最后一次异常
     *
     * @return GameException
     */
    public static function getLastException()
    {
        return empty(self::$exceptions) ? null : \end(self::$exceptions);
    }


    public static function removeLast()
    {
        return \array_pop(self::$exceptions);
    }

    /**
     * 异常处理回调函数
     *
     * @param \Exception $exception
     */
    public static function exceptionHandler(\Exception $exception)
    {
        $config = ZConfig::get('project');
        $model = ZFormater::exception($exception);
        Log::info([\var_export($model, true)], 'exception');
        $info = array();
        $codeArr = explode('_', $exception->realCode);
        if(count($codeArr) > 1) {
            $model['code'] = intval($codeArr[0]);
            $model['message'] = $codeArr[1];
        }
        if ($config['debug_mode']) {
            $info['debug'] = $model;
        }
        $info['msg'] = $model['message'];
        $info['code'] = $model['code'];
        if('Php' == Request::getViewMode()) {
            if ($config['debug_mode']) {
                Request::setTplFile('public/exception.php');
            } else {
                Request::setTplFile('public/error.php');
            }
        }
        Response::display($info);
    }

    /**
     * @return mixed
     * @throws \Exception
     * @desc fatal error处理
     */
    public static function fatalHandler()
    {
        $error = \error_get_last();
        if(empty($error)) {
            return;
        }
        if(!in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR))) {
            return;
        }

        $config = ZConfig::get('project');
        $model = ZFormater::fatal($error);
        $info['data'] = null;
        if ($config['debug_mode']) {
            $info['debug'] = $model;
        }
        Log::info([\var_export($model, true)], 'fatal');
        $info['msg'] = $model['message'];
        $info['code'] = $model['code'];
        Response::status('200');
        if('Php' == Request::getViewMode()) {
            if ($config['debug_mode']) {
                Request::setTplFile('public/exception.php');
            } else {
                Request::setTplFile('public/error.php');
            }
        }
        Response::display($info);
    }
}

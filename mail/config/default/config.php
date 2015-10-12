<?php
/**
 * Created by PhpStorm.
 * User: 王晶
 * Date: 2015/8/27
 * Time: 20:09
 */
use ZPHP\ZPHP;
use ZPHP\Socket\Adapter\Swoole;

//定义当前请求时间
define('NOW_TIME', isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time());

//定义项目根目录
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', ZPHP::getRootPath());
}

//定义项目名称
define('PROJECT_NAME', 'zmail');

//定义模版目录
define('TPL_PATH', ROOT_PATH . DS . 'template' . DS . PROJECT_NAME . DS);

//定义静态地址目录
define('STATIC_URL', '/static/');

//定义上传目录
define('UPLOAD_PATH', ROOT_PATH . DS . 'webroot' . DS . 'upload' . DS);

//项目配置
$config = [
    'server_mode' => 'Socket',
    'project_name' => PROJECT_NAME,
    'app_path' => 'apps',
    'ctrl_path' => 'ctrl',
    'lib_path' => ROOT_PATH . DS . '..' . DS . 'lib',
    'project' => [  //项目配置
        'default_ctrl_name' => 'mail',
        'default_method_name' => 'send',
        'log_path' => ROOT_PATH . DS . 'log' . DS . PROJECT_NAME,
        'static_url' => STATIC_URL,
        'tpl_path' => TPL_PATH,
        'view_mode' => 'Json',
        'app_host' => empty($_SERVER['HTTP_HOST']) ? '' : $_SERVER['HTTP_HOST'],
        'exception_handler' => 'common\MyException::exceptionHandler',
        'fatal_handler' => 'common\MyException::fatalHandler',
        'debug_mode' => 0,
        'ctrl_name' => '_act',
        'method_name' => '_mod',
    ],
    'socket' => array(
        'host' => '0.0.0.0',                          //socket 监听ip
        'port' => 8996,                             //socket 监听端口
        'adapter' => 'Swoole',                          //socket 驱动模块
        'server_type' => Swoole::TYPE_TCP,              //socket 业务模型 tcp/udp/http/websocket
        'protocol' => 'Json',                         //socket通信数据协议
        'daemonize' => 1,                             //是否开启守护进程
        'client_class' => 'socket\\Tcp',            //socket 回调类
        'work_mode' => 3,                             //工作模式：1：单进程单线程 2：多线程 3： 多进程
        'worker_num' => 4,                                 //工作进程数
        'task_worker_num' => 16,                                 //工作进程数
        'max_request' => 0,                            //单个进程最大处理请求数
        'debug_mode' => 0,                                  //打开调试模式
        'open_length_check'     => true,
        'package_length_type'   => 'N',
        'package_length_offset' => 0,       //第N个字节是包长度的值
        'package_body_offset'   => 4,       //第几个字节开始计算长度
        'package_max_length'    => 2000000,  //协议最大长度
    ),
    'mail' => [     //邮件服务相关配置
        'smtp_host' => 'smtp.163.com',                  //邮箱的smtp地址
        'smtp_port' => 25,
        'username' => 'test@163.com',                   //修改为自己的邮箱
        'password' => '123456',                         //修改为自己的密码
        'sendname' => 'zmail.server',                   //发送者名称
    ],
    'route' => [  //url重写
        'static' => [
            '/' => ['main', 'main'],
        ],

        'dynamic' => [
            '/^\/(.+)\/(.+)$/iU' => [
                '{1}',
                '{2}',
                [],
                '/{a}/{m}',
            ]
        ]
    ],
];

return $config;

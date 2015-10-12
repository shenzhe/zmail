<?php

namespace socket;

use ZPHP\Protocol\Request;
use ZPHP\Socket\Callback\Swoole as ZSwoole;
use ZPHP\Socket\IClient;
use ZPHP\Core\Route as ZRoute;

class Tcp extends ZSwoole
{


    public function onReceive()
    {
        list($serv, $fd, $fromId, $data) = func_get_args();
        if (empty($data)) {
            return;
        }
        $taskId = $serv->task($data);
        $serv->send($fd, $taskId.'_'.$fromId);
    }

    public function onTask($server, $taskId, $fromId, $data)
    {
        Request::parse($data);
        Request::addParams('taskId', $taskId.'_'.$fromId);
        try {
            ZRoute::route();
        } catch (\Exception $e) {
            $model = Formater::exception($e);
            ZLog::info('exception', $model);
        }
    }

}

<?php
namespace ctrl;
use common;

class mail extends CtrlBase
{

    public function send()
    {
        $to = $this->getString('to');
        $title = $this->getString('title');
        $content = $this->getString('content');
        $taskId = $this->getString('taskId');
        common\loadClass::getService('Mail')->send($to, $title, $content, $taskId);
        return null;
    }
}

<?php
namespace service;

use common;
use ZPHP\Core\Config as ZConfig;


class Mail
{
    public function send($to, $title, $content, $taskId)
    {
        $mail = common\loadClass::getPhpMail();
        $mail->isSMTP();
        $mail->Host = ZConfig::getField('mail', 'smtp_host');
        $mail->Port = ZConfig::getField('mail', 'smtp_port', 25);
        $mail->SMTPAuth = true;
        $mail->Username = ZConfig::getField('mail', 'username');
        $mail->Password = ZConfig::getField('mail', 'password');
        $mail->setFrom(ZConfig::getField('mail', 'from', $mail->Username), ZConfig::getField('mail', 'sendname', 'layabox开放平台'));
        $mail->addAddress($to);
        $mail->Subject = $title;
        $mail->Body = $content;
        if (!$mail->send()) {
            common\Log::info([$taskId, $to, $title, $content, $mail->ErrorInfo], 'error');
            return false;
        }
        common\Log::info([$taskId, $to, $title, $content, $mail->ErrorInfo], 'success');
        return true;
    }
}

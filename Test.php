<?php

use NotifyException\NotifyException;

require_once __DIR__ . '/vendor/autoload.php';

define('NOTIFY_EXCEPTION_SLACK', [
    'webhook' => 'https://hooks.slack.com/services/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',
    'channel' => 'crm_dev',
    'username' => 'CRM ROBOT'
]);

define('NOTIFY_EXCEPTION_ROCKETCHAT', [
    'webhook' => 'qareer.chatlibs.com/group/crm2_dev'
]);

class MyExceptionClass extends NotifyException
{
    protected function getTraceMessage()
    {
        $basicMessage = parent::getTraceMessage();

        $customMessage = <<<EOD
Account: Budi
LOCATION: http://lalala.com
EOD;

        return $basicMessage . $customMessage;
    }
}

//function exception_handler(MyExceptionClass $exception)
//{
//    trigger_error($exception->getMessage(), E_USER_ERROR);
//}

//set_exception_handler('exception_handler');

try {
    throw new MyExceptionClass('Kuku Kuda Kuda');
} catch (MyExceptionClass $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}
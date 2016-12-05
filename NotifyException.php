<?php

namespace NotifyException;


use NotifyException\Drivers\RocketChatDriver;
use NotifyException\Drivers\SlackDriver;

require_once __DIR__ . 'vendor/autoload.php';


class NotifyException extends \Exception
{
    const CONFIG_NOTIFY_EXCEPTION_SLACK = 'NOTIFY_EXCEPTION_SLACK';
    const CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT = 'NOTIFY_EXCEPTION_ROCKETCHAT';

    public function __construct($message, $code = 0, \Exception $previous = null) {

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_SLACK) ||
            defined(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT)) {

            $this->pushMessage($message);

        } else {
            error_log('NOTIFY_EXCEPTION: No configuration found, please set your config\r\n');
        }

        parent::__construct($message, $code, $previous);

    }

    private function getDriverInstance()
    {
        $drivers = [];

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_SLACK)) {
            /* Get configuration for slack */
            $slackConfig = constant(self::CONFIG_NOTIFY_EXCEPTION_SLACK);

            /* Get instance of driver */
            $drivers[] = (new SlackDriver)->configure([
                'webhook' => $slackConfig['webhook'],
                'channel' => $slackConfig['channel'],
            ]);

        }

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT)) {
            /* Get configuration for chatlibs */
            $chatlibs_config = constant(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT);

            /* Get instance of driver */
            $drivers[] = (new RocketChatDriver)->configure([
                'webhook' => $chatlibs_config['webhook'],
            ]);

        }

        return $drivers;
    }

    /**
     * @param $message
     */
    public function pushMessage($message)
    {
        $drivers = $this->getDriverInstance();

        try {

            foreach ($drivers as $driver) {
                $driver->push($message);
            }

        } catch (\ErrorException $e) {
            error_log('NOTIFY_EXCEPTION: Error to push the message\r\n');
            error_log('NOTIFY_EXCEPTION: \r\n');
            error_log($e->getMessage());
        }
    }

}
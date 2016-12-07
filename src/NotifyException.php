<?php

namespace NotifyException;

use Carbon\Carbon;
use NotifyException\Drivers\RocketChatDriver;
use NotifyException\Drivers\SlackDriver;


class NotifyException extends \Exception
{
    const CONFIG_NOTIFY_EXCEPTION_SLACK = 'NOTIFY_EXCEPTION_SLACK';
    const CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT = 'NOTIFY_EXCEPTION_ROCKETCHAT';
    private $exceptionMessage;

    public function __construct($message, $code = 0, \Exception $previous = null) {

        $this->exceptionMessage = $message;

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_SLACK) ||
            defined(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT)) {

            $this->pushMessage($this->getTraceMessage());

        } else {
            error_log('NOTIFY_EXCEPTION: No configuration found, please set your config\r\n');
        }

        parent::__construct($message, $code, $previous);

    }

    protected function getTraceMessage()
    {
        $time = Carbon::now();
        return <<<EOD
Oops.. Some error happens

> Time: `{$time}`
> Exception: `{$this->exceptionMessage}`
> File: `{$this->getFile()}`
> Line: `{$this->getLine()}`
> Trace: 
```{$this->getTraceAsString()}```

EOD;
    }

    private function getDriverInstance()
    {
        $drivers = [];

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_SLACK)) {
            /* Get configuration for slack */
            $slackConfig = constant(self::CONFIG_NOTIFY_EXCEPTION_SLACK);

            $config = [
                'webhook' => $slackConfig['webhook'],
                'channel' => $slackConfig['channel']
            ];

            if (isset($slackConfig['username'])) {
                $config['username'] = $slackConfig['username'];
            }

            /* Get instance of driver */
            $drivers[] = (new SlackDriver)->configure($config);

        }

        if (defined(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT)) {
            /* Get configuration for chatlibs */
            $chatlibs_config = constant(self::CONFIG_NOTIFY_EXCEPTION_ROCKETCHAT);

            $config = [
                'webhook' => $chatlibs_config['webhook']
            ];

            if (isset($chatlibs_config['title']) ||
                isset($chatlibs_config['title_link']) ||
                isset($chatlibs_config['image_url'])) {

                $attachments = [];

                if (isset($chatlibs_config['title'])) {
                    $attachments['title'] = $chatlibs_config['title'];
                }

                if (isset($chatlibs_config['title_link'])) {
                    $attachments['title_link'] = $chatlibs_config['title_link'];
                }

                if (isset($chatlibs_config['image_url'])) {
                    $attachments['image_url'] = $chatlibs_config['image_url'];
                }

                if (count($attachments) > 0) {
                    $config['attachments'] = [$attachments];
                }

            }

            /* Get instance of driver */
            $drivers[] = (new RocketChatDriver)->configure($config);

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
                echo "Pushing {$driver->getName()}\n";
            }

        } catch (\Exception $e) {
            error_log('NOTIFY_EXCEPTION: Error to push the message\r\n');
            error_log('NOTIFY_EXCEPTION: \r\n');
            error_log($e->getMessage());
        }
    }

}
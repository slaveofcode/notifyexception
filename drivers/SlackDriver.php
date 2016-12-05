<?php

namespace NotifyException\Drivers;

use NotifyException\libraries\Slack;

class SlackDriver implements BaseDriver
{
    private $webhook = NULL;
    private $channel = NULL;

    public function configure($config)
    {
        $this->webhook = $config['webhook'];
        $this->channel = $config['channel'];

        return $this;
    }

    public function push($message)
    {
        return Slack::send($this->webhook, $this->channel, $message, ':longbox:');
    }
}
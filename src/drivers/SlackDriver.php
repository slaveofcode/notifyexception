<?php

namespace NotifyException\Drivers;

use NotifyException\libraries\Slack;

class SlackDriver implements BaseDriver
{
    private $webhook = NULL;
    private $channel = NULL;
    private $botName = NULL;

    public function configure($config)
    {
        $this->webhook = $config['webhook'];
        $this->channel = $config['channel'];
        $this->botName = $config['username'];

        return $this;
    }

    public function push($message)
    {
        return Slack::send($this->webhook, $this->channel, $message, ':ghost:', $this->botName);
    }

    public function getName()
    {
        return 'Slack';
    }
}
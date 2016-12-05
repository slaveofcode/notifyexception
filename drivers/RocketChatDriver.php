<?php

namespace NotifyException\Drivers;


use NotifyException\libraries\RocketChat;

class RocketChatDriver implements BaseDriver
{
    private $webhook = NULL;

    public function configure($config)
    {
        $this->webhook = $config['webhook'];

        return $this;
    }

    public function push($message)
    {
        return RocketChat::send($this->webhook, $message);
    }
}
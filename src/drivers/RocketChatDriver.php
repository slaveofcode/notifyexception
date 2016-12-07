<?php

namespace NotifyException\Drivers;


use NotifyException\libraries\RocketChat;

class RocketChatDriver implements BaseDriver
{
    private $webhook = NULL;
    private $attachments = NULL;

    public function configure($config)
    {
        $this->webhook = $config['webhook'];
        $this->attachments = (isset($config['attachments'])) ? $config['attachments'] : NULL;

        return $this;
    }

    public function push($message)
    {
        return RocketChat::send($this->webhook, $message, $this->attachments);
    }

    public function getName()
    {
        return 'RocketChat';
    }
}
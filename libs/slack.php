<?php

namespace NotifyException\libraries;

class Slack
{
    public static function send($webhook, $channel, $message, $icon = NULL)
    {

        $data = "payload=" . json_encode(array(
                "channel"       =>  "#{$channel}",
                "text"          =>  $message,
                "icon_emoji"    =>  $icon
            ));

        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
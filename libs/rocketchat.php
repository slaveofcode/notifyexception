<?php

namespace NotifyException\libraries;

class RocketChat
{
    public static function send($webhook, $message)
    {
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'payload='.json_encode(['text' => $message]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
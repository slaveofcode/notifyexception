<?php

namespace NotifyException\libraries;

use Aws\CloudFront\Exception\Exception;

class RocketChat
{
    public static function send($webhook, $message)
    {

        $data = 'payload='.json_encode(['text' => $message]);

        try{
            $ch = curl_init($webhook);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            $result = FALSE;
        }

        return $result;
    }
}
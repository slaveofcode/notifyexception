<?php

namespace NotifyException\libraries;

class RocketChat
{
    public static function send($webhook, $message, $attachments = NULL)
    {

        $payload = ['text' => $message];

        if (!is_null($attachments)) {
            $payload['attachments'] = $attachments;
        }

        $data = 'payload='.json_encode($payload);

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
<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:37
 */

namespace FacebookBot\Api\Message;

class Factory
{

    public static function makeFromApi(array $message)
    {

        if (isset($message['quick_reply'])) {
            return new QuickReply($message);
        } elseif (isset($message['is_echo'])) {
            return new MessageEcho($message);
        } else {
            return new WebhookMessage($message);
        }

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:37
 */

namespace FacebookBot\Api\Message;

use FacebookBot\Api\Exception\ApiException;

class Factory
{

    public static function makeFromApi(array $message)
    {

        if (isset($message['quick_reply'])) {
            return new Text($message);
        }

        if (isset($message['attachments'])) {
            return new Attachments($message);
        }

        throw new ApiException('unknown message data');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:39
 */

namespace FacebookBot\Api\Event;


class Factory
{

    public static function makeFromApi(array $data)
    {
        if (isset($data['message'])) {
            return new Message($data);
        } elseif (isset($data['delivery'])) {
            return new Delivered($data);
        }
    }

}
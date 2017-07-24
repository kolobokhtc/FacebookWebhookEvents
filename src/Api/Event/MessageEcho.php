<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 13:06
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class MessageEcho extends Event
{

    public function __construct(array $data)
    {

        $this->event = new \FacebookBot\Api\Message($data);

    }


}
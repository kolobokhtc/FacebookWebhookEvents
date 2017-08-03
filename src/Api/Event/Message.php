<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 13:06
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class Message extends Event
{

    public function __construct(array $data, Event $entryEvent = null )
    {

        parent::__construct($data, $entryEvent);

        $this->event = new \FacebookBot\Api\Message($data);

    }


}
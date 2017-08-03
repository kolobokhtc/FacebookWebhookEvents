<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 15:45
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class QuickReply extends Event
{

    public function __construct(array $data, Event $entryEvent = null )
    {

        parent::__construct($data, $entryEvent);

        $this->event = new \FacebookBot\Api\Message($data);

    }

}
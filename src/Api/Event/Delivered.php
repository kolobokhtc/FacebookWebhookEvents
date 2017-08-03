<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:56
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class Delivered extends Event
{

    public function __construct(array $data, Event $entryEvent = null )
    {

        parent::__construct($data, $entryEvent);

        $this->event = new \FacebookBot\Api\Delivered($data);

    }

}
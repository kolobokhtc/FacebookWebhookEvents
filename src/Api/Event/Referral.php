<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 16:06
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class Referral extends Event
{

    public function __construct(array $data, Event $entryEvent = null )
    {

        parent::__construct($data, $entryEvent);

        $this->event = new \FacebookBot\Api\Referral($data);

    }

}
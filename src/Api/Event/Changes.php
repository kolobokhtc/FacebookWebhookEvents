<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 16:06
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class Changes extends Event
{

    public function __construct($data)
    {

        $this->event = new \FacebookBot\Api\Changes($data);

    }

}
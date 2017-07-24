<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:56
 */

namespace FacebookBot\Api\Event;


use FacebookBot\Api\Event;

class Read extends Event
{

    public function __construct(array $data)
    {

        $this->event = new \FacebookBot\Api\Read($data);

    }

}
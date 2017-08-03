<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:02
 */

namespace FacebookBot\Api;


class Event
{

    protected $event;

    protected $entryEvent;

    public function __construct($data, Event $entryEvent = null)
    {

        $this->entryEvent = $entryEvent;

    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return mixed
     */
    public function getEntryEvent()
    {

        if (!is_null($this->entryEvent) && $this->entryEvent instanceof Event) {
            return $this->entryEvent->getEvent();
        }

        return false;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:54
 */

namespace FacebookBot\Api;


class Read extends Entity
{

    public $sender;

    public $recipient;

    public $timestamp;

    public $read;

    public function toArray()
    {
        return [
            'sender' => $this->getSender()->toArray(),
            'recipient' => $this->getRecipient()->toArray(),
            'timestamp' => $this->getTimestamp(),
            'read' => $this->getRead()
        ];
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return new Sender($this->sender);
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return new Recipient($this->recipient);
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }


}
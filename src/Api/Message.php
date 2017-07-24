<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:05
 */

namespace FacebookBot\Api;

use FacebookBot\Api\Message\Factory;

class Message extends Entity
{

    public $sender;

    public $recipient;

    public $timestamp = null;

    public $message;

    protected $type;

    public function toArray()
    {
        return [
            'sender' => $this->getSender()->toArray(),
            'recipient' => $this->getRecipient()->toArray(),
            'timestamp' => $this->getTimestamp(),
            'message' => $this->getMessage()->toArray()
        ];
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {

        $messageFactory = new Factory();

        return $messageFactory::makeFromApi($this->message);
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return new Sender($this->sender);
    }

    /**
     * @param mixed $sender
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender->toArray();
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return new Recipient($this->recipient);
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient(Recipient $recipient)
    {
        $this->recipient = $recipient->toArray();
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }


}
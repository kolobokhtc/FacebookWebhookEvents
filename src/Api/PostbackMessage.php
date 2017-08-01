<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 16:02
 */

namespace FacebookBot\Api;


class PostbackMessage extends Entity
{

    public $sender;

    public $recipient;

    public $timestamp = null;

    public $postback;

    public function toArray()
    {
        return [
            'sender' => $this->getSender()->toArray(),
            'recipient' => $this->getRecipient()->toArray(),
            'timestamp' => $this->getTimestamp(),
            'postback' => $this->getPostback()
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
    public function getPostback()
    {
        return $this->postback;
    }

}
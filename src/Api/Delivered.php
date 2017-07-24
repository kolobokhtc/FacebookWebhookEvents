<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:54
 */

namespace FacebookBot\Api;


class Delivered extends Entity
{

    public $sender;

    public $recipient;

    public $delivery;

    public function toArray()
    {
        return [
            'sender' => $this->getSender()->toArray(),
            'recipient' => $this->getRecipient()->toArray(),
            'delivery' => $this->getDelivery()
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
    public function getDelivery()
    {
        return $this->delivery;
    }


}
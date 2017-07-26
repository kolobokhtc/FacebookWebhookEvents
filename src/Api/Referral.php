<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 16:02
 */

namespace FacebookBot\Api;


class Referral extends Entity
{

    public $sender;

    public $recipient;

    public $timestamp = null;

    public $referral;

    public function toArray()
    {
        return [
            'sender' => $this->getSender()->toArray(),
            'recipient' => $this->getRecipient()->toArray(),
            'timestamp' => $this->getTimestamp(),
            'referral' => $this->getReferral()
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
    public function getReferral()
    {
        return $this->referral;
    }


}
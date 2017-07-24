<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:10
 */

namespace FacebookBot\Api\Message;

use FacebookBot\Api\Entity;
use FacebookBot\Api\Payload;

class QuickReply extends Entity
{

    public $mid;

    public $text;

    public $quick_reply;

    public function toArray()
    {
        return [
            'mid' => $this->mid,
            'text' => $this->getText(),
            'quick_reply' => $this->getQuickReply()->toArray()
        ];
    }

    public function getType()
    {
        return Type::TEXT;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getQuickReply()
    {
        return new Payload($this->quick_reply);
    }

    /**
     * @param mixed $quick_reply
     */
    public function setQuickReply(Payload $quick_reply)
    {
        $this->quick_reply = $quick_reply->toArray();
    }


}
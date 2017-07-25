<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 11:27
 */

namespace FacebookBot\Api;

class Payload extends Entity
{

    public $payload;

    public $title;

    public function toArray()
    {
        return [
            'payload' => $this->getPayload(),
            'title' => $this->getTitle()
        ];
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->text;
    }


}
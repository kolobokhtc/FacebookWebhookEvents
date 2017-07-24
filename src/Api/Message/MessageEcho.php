<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 15:40
 */

namespace FacebookBot\Api\Message;


class MessageEcho extends WebhookMessages
{

    public $is_echo;
    public $app_id;
    public $metadata;

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'is_echo' => $this->getisEcho(),
            'app_id' => $this->getAppId(),
            'metadata' => $this->getMetadata()
        ]);
    }

    /**
     * @return mixed
     */
    public function getisEcho()
    {
        return $this->is_echo;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }


}
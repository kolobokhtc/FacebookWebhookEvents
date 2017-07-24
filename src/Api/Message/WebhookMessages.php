<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 12:07
 */

namespace FacebookBot\Api\Message;


use FacebookBot\Api\Attachment;
use FacebookBot\Api\Entity;

class WebhookMessages extends Entity
{

    public $mid;

    public $text;

    public $attachments;

    public function toArray()
    {

        $result = [];
        $attachments = $this->getAttachments();
        if (is_array($attachments) && !empty($attachments)) {
            foreach ($attachments as $attachment) {
                $result[] = $attachment->toArray();
            }
        } else {
            $result = null;
        }

        return [
            'mid' => $this->mid,
            'text' => $this->getText(),
            'attachments' => $result
        ];
    }

    public function getType()
    {
        return Type::ATTACHMENTS;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {

        $result = [];

        if (is_array($this->attachments) && !empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $result[] = new Attachment($attachment);
            }

            return $result;
        }

        return $this->attachments;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }


}
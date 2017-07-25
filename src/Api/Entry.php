<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 11:00
 */

namespace FacebookBot\Api;


class Entry extends Entity
{

    public $id;

    public $time;

    public $messaging;

    public $changes;

    public function toArray()
    {

        $result = [];
        $messages = $this->getMessaging();
        if (is_array($messages) && !empty($messages)) {
            foreach ($messages as $message) {
                $result[] = $message->toArray();
            }
        } else {
            $result[] = $messages->toArray();
        }

        $changesResult = [];
        $changes = $this->getChanges();
        if (is_array($changes) && !empty($changes)) {
            foreach ($changes as $change) {
                $changesResult[] = $change->toArray();
            }
        } else {
            $changesResult[] = $changes->toArray();
        }

        return [
            'id' => $this->getId(),
            'time' => $this->getTime(),
            'messaging' => $result,
            'changes' => $changesResult
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getMessaging()
    {
        if (!is_array($this->messaging)) {
            return new Message($this->messaging);
        }

        $result = [];

        foreach ($this->messaging as $message) {
            if (isset($message['read'])) {
                $result[] = new Read($message);
            } else if (isset($message['delivery'])) {
                $result[] = new Delivered($message);
            } else if (isset($message['postback'])) {
                $result[] = new PostbackMessage($message);
            } else {
                $result[] = new Message($message);
            }
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getChanges()
    {
        if (!is_array($this->changes)) {
            return new Changes($this->changes);
        }

        $result = [];

        foreach ($this->changes as $change) {
            $result[] = new Changes($change);
        }

        return $result;
    }


}
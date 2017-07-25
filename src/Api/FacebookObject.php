<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 11:03
 */

namespace FacebookBot\Api;


class FacebookObject extends Entity
{

    public $object;

    public $entry;

    public function toArray()
    {

        $result = [];
        $entrys = $this->getEntry();
        if (is_array($entrys) && !empty($entrys)) {
            foreach ($entrys as $entry) {
                $result[] = $entry->toArray();
            }
        } else {
            $result[] = $entrys->toArray();
        }

        return [
            'object' => $this->getObject(),
            'entry' => result
        ];
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return mixed
     */
    public function getEntry()
    {

        if (!is_array($this->entry)) {
            return new Entry($this->entry);
        }

        $result = [];

        if ($this->getObject() == 'page') {

            foreach ($this->entry as $entry) {
                $result[] = new Entry($entry);
            }

        }

        return $result;
    }


}
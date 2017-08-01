<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 25.07.2017 11:30
 */

namespace FacebookBot\Api;


class Changes extends Entity
{

    public $field;
    public $value;

    public function toArray()
    {
        return [
            'field' => $this->getField(),
            'value' => $this->getValue()
        ];
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}
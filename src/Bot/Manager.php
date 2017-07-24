<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 13:00
 */

namespace FacebookBot\Bot;
use FacebookBot\Api\Event;

class Manager
{

    protected $checker;

    protected $handler;

    public function __construct(\Closure $checker, \Closure $handler)
    {

        $this->checker = $checker;
        $this->handler = $handler;

    }

    /**
     * @return mixed
     */
    public function getChecker()
    {
        return $this->checker;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    public function isMatch(Event $event)
    {
        if (is_callable($this->checker)) {
            return call_user_func($this->checker, $event);
        }
        return false;
    }

    public function runHandler(Event $event){
        if (is_callable($this->handler)) {
            return call_user_func($this->handler, $event);
        }
    }


}
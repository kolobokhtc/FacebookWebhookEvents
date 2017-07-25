<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 12:59
 */

namespace FacebookBot;


use FacebookBot\Api\Event;
use FacebookBot\Api\Event\Factory;
use FacebookBot\Bot\Manager;

class Bot
{

    protected $managers = [];

    public function on(\Closure $checker, \Closure $handler)
    {
        $this->managers[] = new Manager($checker, $handler);
    }

    public function onObject(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\FacebookObject);
        }, $handler);

        return $this;
    }

    public function onEntry(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\Entry);
        }, $handler);

        return $this;
    }

    public function onMessage($regex, \Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) use ($regex) {
            return (
                $event instanceof \FacebookBot\Api\Event\Message
                && preg_match($regex, $event->getEvent()->getMessage()->getText())
            );
        }, $handler);

        return $this;
    }

    public function onMessageWithAttachment($regex, \Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) use ($regex) {
            return (
                $event instanceof \FacebookBot\Api\Event\Message
                && preg_match($regex, $event->getEvent()->getMessage()->getText())
                && $event->getEvent()->getMessage()->getAttachments()
            );
        }, $handler);

        return $this;
    }

    public function onDelivery(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\Delivered);
        }, $handler);

        return $this;
    }

    public function onRead(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\Read);
        }, $handler);

        return $this;
    }

    public function onEcho(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\MessageEcho);
        }, $handler);

        return $this;
    }

    public function run($event = null)
    {
        if (is_null($event)) {

            $eventBody = file_get_contents('php://input');

            $eventBody = json_decode($eventBody, TRUE);
            if (json_last_error() || empty($eventBody) || !is_array($eventBody)) {
                throw new \RuntimeException('Invalid json request', 1);
            }

            $event = Factory::makeFromApi($eventBody);

        }

        if (is_array($event)) {
            foreach ($event as $i) {
                $this->_process($i);
            }
        } else {
            $this->_process($event);
        }

        return $this;
    }

    private function _process(Event $event)
    {

        if (!$event instanceof Event) {
            throw new \RuntimeException('Event must be instance of FacebookBot\Api\Event', 2);
        }

        foreach ($this->managers as $manager) {
            if ($manager->isMatch($event)) {
                $returnValue = $manager->runHandler($event);
                if ($returnValue && $returnValue instanceof Entity) {
                    $this->outputEntity($returnValue);
                }
                break;
            };
        }
    }

    public function outputEntity(Entity $entity)
    {
        header('Content-Type: application/json');
        echo json_encode($entity->toArray());
    }

}
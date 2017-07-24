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

    public function onMessage(\Closure $handler)
    {
        $this->managers[] = new Manager(function (Event $event) {
            return ($event instanceof \FacebookBot\Api\Event\Message);
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

    public function run($event = null)
    {
        if (is_null($event)) {

            $eventBody = file_get_contents('php://input');

            $eventBody = json_decode($eventBody, TRUE);
            if (json_last_error() || empty($eventBody) || !is_array($eventBody)) {
                throw new \RuntimeException('Invalid json request', 1);
            }

            $event = Factory::makeFromApi($event);

        } elseif (!$event instanceof Event) {
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

        return $this;
    }

    public function outputEntity(Entity $entity)
    {
        header('Content-Type: application/json');
        echo json_encode($entity->toArray());
    }

}
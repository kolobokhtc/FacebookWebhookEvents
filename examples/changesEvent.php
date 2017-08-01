<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 9:38
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../vendor/autoload.php");

use FacebookBot\Api\Event;
use FacebookBot\Api\Event\Factory;
use FacebookBot\Client;

try {
    $client = new Client();

    $json_test = '{
        "object": "page",
        "entry": 
        [
            {
                "id": "1563517177225371",
                "time": 1501575523,
                "changes": 
                [
                    {
                        "field": "conversations", 
                        "value": 
                            {
                                "thread_id": "t_mid.$cAAXU8ftoSZBiW9yWQlcKpdEFE6rQ",
                                 "page_id": 1563517177225371,
                                 "thread_key": "t_100001042311435"
                             }
                     }
                ]
            }
        ]
    }';
    $data = json_decode($json_test, true, 512, JSON_BIGINT_AS_STRING);
    $event = Factory::makeFromApi($data);

    try {
        $bot = new \FacebookBot\Bot();

        $bot->onObject(function ($event) {
            echo "OBJECT RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onEntry(function ($event) {
            echo "ENTRY RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onChanges(function (Event $event) {
            echo "CHANGES EVENT CALLBACK\n";
            $data = $event->getEvent();
            $field = $data->getField();
            $value = $data->getValue();

            $thread_id = (isset($value['thread_id'])) ? $value['thread_id'] : false;
            $page_id = (isset($value['page_id'])) ? $value['page_id'] : false;
            $thread_key = (isset($value['thread_key'])) ? $value['thread_key'] : false;

            var_dump($field, $value, $thread_id, $page_id, $thread_key);

        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


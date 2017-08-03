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
                "messaging": 
                [
                    {
                        "sender":{
                            "id":"USER_ID"
                        },
                        "recipient":{
                            "id":"PAGE_ID"
                        },
                        "timestamp":1458668856463,
                        "optin":{
                            "ref":"PASS_THROUGH_PARAM"
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
        })->onOptin(function (Event $event) {
            //event when we recive message with any text
            echo "MESSAGE EVENT CALLBACK\n";
            $data = $event->getEvent();

            $pageId = null;
            $time = null;
            if ($event->getEntry() instanceof \FacebookBot\Api\Entry) {
                $pageId = $event->getEntry()->getId();
                $time = $event->getEntry()->getTime();
            }

            $senderId = $data->getSender()->getId();
            $recipientId = $data->getRecipient()->getId();
            $timestamp = $data->getTimestamp();

            $optin = $data->getOptin();

            if (!empty($optin)) {
                $ref = $optin['ref'];
            }

            var_dump($pageId, $senderId, $recipientId, $timestamp, $optin, $ref);

        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


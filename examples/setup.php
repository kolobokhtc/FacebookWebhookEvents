<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 9:38
 */

require_once("../vendor/autoload.php");

use FacebookBot\Api\Event;
use FacebookBot\Api\Event\Factory;
use FacebookBot\Client;

try {
    $client = new Client();

    $json_test = '{
      "sender":{
        "id":"USER_ID"
      },
      "recipient":{
        "id":"PAGE_ID"
      },
      "timestamp":1458692752478,
      "message":{
        "mid":"mid.1458696618141:b4ef9d19ec21086067",
        "attachments":[
          {
            "type":"fallback",
            "payload":null,
            "title":"TITLE_OF_THE_URL_ATTACHMENT",
            "URL":"URL_OF_THE_ATTACHMENT"
          }
        ]
      }
    }';

    $data = json_decode($json_test, TRUE);

    $event = Factory::makeFromApi($data);

    try {
        $bot = new \FacebookBot\Bot();
        $bot->onMessage('|hello|i', function (Event $event) {
            echo "MESSAGE RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onMessageWithAttachment('|.*|i', function (Event $event) {
            echo "MESSAGE WITH ATTACHMENT RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onDelivery(function ($event) {
            echo "MESSAGE DELIVERY CALLBACK\n";
            $data = $event->getEvent();
        })->onRead(function ($event) {
            echo "MESSAGE READ CALLBACK\n";
            $data = $event->getEvent();
        })->onEcho(function ($event) {
            echo "MESSAGE ECHO CALLBACK\n";
            $data = $event->getEvent();
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


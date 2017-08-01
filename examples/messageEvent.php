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
                        "timestamp":1458692752478,
                        "message": {
                            "mid":"mid.1457764197618:41d102a3e1ae206a38",
                            "text":"hello, world!",
                            "attachments":[
                                {
                                    "type":"image",
                                    "payload":{
                                        "url":"IMAGE_URL"
                                    }
                                }
                            ]
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
        })->onMessage('|.*|i', function (Event $event) {
            //event when we recive message with any text
            echo "MESSAGE EVENT CALLBACK\n";
            $data = $event->getEvent();

            $senderId = $data->getSender()->getId();
            $recipientId = $data->getRecipient()->getId();
            $timestamp = $data->getTimestamp();

            $message = $data->getMessage();
            if (!empty($message)) {
                $mid = $message->getMid();
                $text = $message->getText();
                $attachments = $message->getAttachments();
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $type = $attachment->getType();
                        $payload = $attachment->getPayload();
                        if (!empty($payload)) {
                            $payload_url = $payload['url'];
                        }
                        $title = $attachment->getTitle();
                        $url = $attachment->getUrl();
                    }
                }
            }
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


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

    $json_test = '{"object":"page","entry":[{"id":"1104343819608576","time":1501055113722,"messaging":
    [{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1234567890,
  "optin":{
    "ref":"PASS_THROUGH_PARAM"
  }
}  ]}]}';
    $data = json_decode($json_test, TRUE);
    $event = Factory::makeFromApi($data);

    try {
        $bot = new \FacebookBot\Bot();

        $bot->onObject(function ($event) {
            echo "OBJECT RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onEntry(function ($event) {
            echo "ENTRY RECEIVE CALLBACK\n";
            $data = $event->getEvent();
        })->onMessage('|hello|i', function (Event $event) {
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
        })->onQuickReply(function ($event) {
            echo "QUICK REPLY MESSAGE CALLBACK\n";
            $data = $event->getEvent();
            $payload = $data->getMessage()->getQuickReply()->getPayload();
        })->onPostbackMessage(function ($event) {
            echo "POST BACK MESSAGE CALLBACK\n";
            $data = $event->getEvent();
            $payload = $data->getPostback();
            if (isset($payload->payload)){
                $action = json_decode($payload->getPayload(), TRUE);
                if (!json_last_error() && !empty($action)){
                    if ($action['action'] == 'show_menu'){
                        echo 'there';
                    }
                }
            }
        })->onOptin(function ($event) {
            echo "OPTIN RECEIVED CALLBACK\n";
            $data = $event->getEvent();
            $optin = $data->getOptin();
            $ref = $optin['ref'];
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


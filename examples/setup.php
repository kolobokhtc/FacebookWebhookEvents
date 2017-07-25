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

    $json_test = '{"object":"page","entry":[{"id":"1104343819608576","time":1500984951676,"messaging":[{"sender":{"id":"863758473728483"},"recipient":{"id":"1104343819608576"},"timestamp":1500984840177,"message":{"quick_reply":{"payload":"PAYLOAD"},"mid":"mid.$cAAPsZVYUuwhjqvBX8Vdeascl0bNI","seq":5067,"text":"QR button"}}]}]}';
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
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


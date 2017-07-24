<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 9:38
 */

require_once("../vendor/autoload.php");

use FacebookBot\Api\Event\Factory;
use FacebookBot\Api\Event;
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
           "delivery":{
              "mids":[
                 "mid.1458668856218:ed81099e15d3f4f233"
              ],
              "watermark":1458668856253,
              "seq":37
           }
        }    ';

    $data = json_decode($json_test, TRUE);

    $event = Factory::makeFromApi($data);

    try {
        $bot = new \FacebookBot\Bot();
        $bot->onMessage(function (Event $event) {
            $data = $event->getEvent();
        })->onDelivery(function($event){
            $data = $event->getEvent();
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


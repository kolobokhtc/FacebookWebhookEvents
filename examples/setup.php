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
    "object":"page",
    "entry":
        [
            {
                "id":"1104343819608576",
                "time":1501055113722,
                "messaging":
                [
                    {
                        "sender":{"id":"<USER ID>"},
                        "recipient":{"id":"<PAGE ID>"},
                        "timestamp":1458692752478,
                        "referral": {
                            "ref": "REF DATA PASSED IN M.ME PARAM",
                            "source": "SHORTLINK",
                            "type": "OPEN_THREAD"
                          }
                    }  
                ]
            }
        ]
    }';
    $data = json_decode($json_test, true, 512, JSON_BIGINT_AS_STRING);
    var_dump($data);
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
            if (isset($payload->payload)) {
                $action = json_decode($payload->getPayload(), TRUE);
                if (!json_last_error() && !empty($action)) {
                    if ($action['action'] == 'show_menu') {
                        echo 'there';
                    }
                }
            }
        })->onOptin(function ($event) {
            echo "OPTIN RECEIVED CALLBACK\n";
            $data = $event->getEvent();
            $optin = $data->getOptin();
            $ref = (isset($optin['ref'])) ? $optin['ref'] : FALSE;;
        })->onReferral(function ($event) {
            echo "REFERRAL RECEIVED CALLBACK\n";
            $data = $event->getEvent();
            $referral = $data->getReferral();
            $ref = (isset($referral['ref'])) ? $referral['ref'] : FALSE;
            $source = (isset($referral['source'])) ? $referral['source'] : FALSE;
            $type = (isset($referral['type'])) ? $referral['type'] : FALSE;
            $ad_id = (isset($referral['ad_id'])) ? $referral['ad_id'] : FALSE;
            var_dump($ref, $source, $type, $ad_id);
        })->run($event);
    } catch (RuntimeException $e) {
        echo $e->getMessage();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getError() . "\n";
}


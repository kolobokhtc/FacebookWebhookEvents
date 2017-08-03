<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 14:39
 */

namespace FacebookBot\Api\Event;


class Factory
{

    public static function makeFromApi(array $data)
    {

        $events = [];

        if (isset($data['object'])) {
            $events[] = new FacebookObject($data);

            if (isset($data['entry']) && is_array($data['entry'])) {
                foreach ($data['entry'] as $entry) {

                    $entryEvent = new Entry($entry);

                    $events[] = $entryEvent;

                    if (isset($entry['messaging']) && is_array($entry['messaging'])) {
                        foreach ($entry['messaging'] as $message) {
                            if (isset($message['message'])) {
                                if (isset($message['message']['is_echo'])) {
                                    $events[] = new MessageEcho($message, $entryEvent);
                                } elseif (isset($message['message']['quick_reply'])) {
                                    $events[] = new QuickReply($message, $entryEvent);
                                } else {
                                    $events[] = new Message($message, $entryEvent);
                                }
                            } elseif (isset($message['delivery'])) {
                                $events[] = new Delivered($message, $entryEvent);
                            } elseif ((isset($message['read']))) {
                                $events[] = new Read($message, $entryEvent);
                            } elseif ((isset($message['postback']))) {
                                $events[] = new PostbackMessage($message, $entryEvent);
                            } elseif ((isset($message['optin']))) {
                                $events[] = new Optin($message, $entryEvent);
                            } elseif ((isset($message['referral']))) {
                                $events[] = new Referral($message, $entryEvent);
                            }
                        }
                    }

                    if (isset($entry['changes']) && is_array($entry['changes'])) {
                        foreach ($entry['changes'] as $change) {
                            $events[] = new Changes($change, $entryEvent);
                        }
                    }
                }
            }
        }


        return $events;

    }

}
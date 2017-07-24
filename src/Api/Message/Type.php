<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 12:19
 */

namespace FacebookBot\Api\Message;


interface Type
{

    const TEXT = 'text';
    const ATTACHMENTS = 'attachment';
    const ATTACHMENT_WITH_URL = 'attachment_with_url';

}
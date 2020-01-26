<?php

namespace App\Workers;
use BeyondCode\Mailbox\InboundEmail;

class MailboxWorker {

    function __invoke(InboundEmail $email){
        print_r($email->from());
        print_r($email->message());
    }
}
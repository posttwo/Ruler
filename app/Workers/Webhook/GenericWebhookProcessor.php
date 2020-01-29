<?php

namespace App\Workers\Webhook;
use App\WebhookInvocation;

/**
 * Generic processor is expected to fully handle incoming webhooks via rules.
 */
class GenericWebhookProcessor {

    public function invoke(WebhookInvocation $invocation){
        //dd($invocation);
    }

}
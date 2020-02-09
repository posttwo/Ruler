<?php

namespace App\Workers\Webhook;
use App\WebhookInvocation;
use App\Services\ConduitService;

/**
 * Ticket processor will create a ticket based on webhooks rules
 */
class MailWebhookProcessor extends TicketWebhookProcessor{

    protected function getRules(WebhookInvocation $invocation)
    {
        $rules = $invocation->webhook->rules()->where('condition_type', 'field_to')->where('condition_value', $invocation->body['rcpt_to'])->get();
        return $rules;
    }

}
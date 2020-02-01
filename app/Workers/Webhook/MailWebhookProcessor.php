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
        return $invocation->webhook->rules;
    }

}
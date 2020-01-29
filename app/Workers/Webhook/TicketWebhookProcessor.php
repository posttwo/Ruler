<?php

namespace App\Workers\Webhook;
use App\WebhookInvocation;

/**
 * Ticket processor will create a ticket based on webhooks rules
 */
class TicketWebhookProcessor extends GenericWebhookProcessor{

    public function invoke(WebhookInvocation $invocation){
        $ticket = new \stdClass();

        $rules = $invocation->webhook->rules;
        foreach($rules as $rule)
        {
            $action = app('App\Workers\Webhook\Actions\\' . $rule->action);
            $ticket = $action->invoke($ticket, $invocation, $rule->config);
        }

        dd($ticket);
        //dd($invocation);
    }

}
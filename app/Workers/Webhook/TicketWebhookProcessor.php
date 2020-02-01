<?php

namespace App\Workers\Webhook;
use App\WebhookInvocation;
use App\Services\ConduitService;

/**
 * Ticket processor will create a ticket based on webhooks rules
 */
class TicketWebhookProcessor extends GenericWebhookProcessor{

    public function __construct(ConduitService $conduit){
        $this->conduit = $conduit;
    }

    public function invoke(WebhookInvocation $invocation){
        $ticket = [];
        $rules = $this->getRules($invocation);

        foreach($rules as $rule)
        {
            $action = app('App\Workers\Webhook\Actions\\' . $rule->action);
            $response = $action->invoke($ticket, $invocation, $rule->config);
            
            if(isset($response['transaction']))
                $ticket['transactions'][] = $response['transaction'];

        }

        $this->submitTicket($ticket);
    }

    protected function getRules(WebhookInvocation $invocation)
    {
        return $invocation->webhook->rules;
    }

    protected function submitTicket($ticket)
    {
        $result = $this->conduit->callMethodSynchronous('maniphest.edit', $ticket);
    }

}
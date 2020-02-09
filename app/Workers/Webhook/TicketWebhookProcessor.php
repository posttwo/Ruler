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
        $ticket['transactions'] = [];
        $rules = $this->getRules($invocation);
        foreach($rules as $rule)
        {

            if($rule->condition_type == 'field_to' && isset($invocation->body['rcpt_to']) && $rule->condition_value != $invocation->body['rcpt_to']) //rcpt_to
                continue;

            $action = app('App\Workers\Webhook\Actions\\' . $rule->action);
            $response = $action->invoke($ticket, $invocation, $rule->config);
            
            if(isset($response['transactions'])){
                $ticket['transactions'] = array_merge($ticket['transactions'], $response['transactions']);
            }

            if(isset($response['root_field']))
                $ticket[$response['root_field']['name']] = $response['root_field']['value'];

        }
        dd($ticket);
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
<?php

namespace App\Workers\Webhook;
use App\WebhookInvocation;

/**
 * Ticket processor will create a ticket based on webhooks rules
 */
class TicketWebhookProcessor extends GenericWebhookProcessor{

    protected $ticketTitle;
    protected $ticketDescription;
    protected $ticketProjects = [];

    /**
     * List of valid actions that rules can take
     */
    protected $RULE_ACTIONS = [
        'setTitle', 'setDescription', 'addProject'
    ];

    public function invoke(WebhookInvocation $invocation){
        //Grab rules corresponding to invocation webhook
        //dd($invocation);
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($d)
    {
        $this->ticketDescription = $d;
    }

    public function addProject($phid)
    {
        $this->ticketProjects[] = $phid;
    }


}
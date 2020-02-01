<?php

namespace App\Workers\Webhook\Actions\Tickets;
use App\Traits\ReplacesMacros;

class GenericTicketFieldAction {
    use ReplacesMacros;

    public function invoke($ticket, $invocation, $config){
        $body = $invocation->body;
        $head = $invocation->head;
        $vars = ['body' => $body, 'head' => $head];
        $title = $config['value'];
        $title = $this->replaceMacro($title, $vars);

        return 
        [
            'transaction' => [
                'type' => $config['field'],
                'value' => $title
            ]
        ];
    }
}
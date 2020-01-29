<?php

namespace App\Workers\Webhook\Actions;
use Illuminate\Support\Arr;

class SetTitleAction {

    public function invoke($ticket, $invocation, $config){
        $body = $invocation->body;
        $head = $invocation->head;
        $vars = ['body' => $body, 'head' => $head];
        $title = $config['title'];

        $title = preg_replace_callback('/{{([^}]+)}}/', function ($needle) use ($vars) {
            $value = Arr::get($vars, $needle[1]);
            //if array set to first element
            if(is_array($value))
                $value = $value[0];
            return $value;
            
        }, $title);

        $ticket->title = $title;
        return $ticket;
    }
}
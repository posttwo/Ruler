<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webhook;
use App\WebhookInvocation;
use App\Enums\WebhookInvocationStatus;
use App\Jobs\ProcessWebhookInvocation;

class WebhookController extends Controller
{
    public function index() {
        return view('webhook.index');
    }

    public function invoke(Webhook $webhook, Request $request)
    {
        $invocation = new WebhookInvocation;
        $invocation->head = $request->headers->all();
        $invocation->body = $request->all();
        $invocation->status = WebhookInvocationStatus::ADDED;
        $invocation->webhook()->associate($webhook);
        $invocation->save();

        //ProcessWebhookInvocation::dispatch($invocation);
        return "Thanks for the fish!";
        //Need to  start queue job probs via an observer @TODO
    }
}

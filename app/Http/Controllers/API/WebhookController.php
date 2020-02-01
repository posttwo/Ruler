<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Webhook;
use App\WebhookRule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Auth;

class WebhookController extends Controller
{
    public function index()
    {
        return Webhook::orderBy('id', 'desc')->get();
    }

    public function indexInvocations(Webhook $webhook)
    {
        return $webhook->invocations()->orderBy('id', 'desc')->get();
    }

    public function indexRules(Webhook $webhook)
    {
        return $webhook->rules()->orderBy('id', 'asc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => [
                'required',
                Rule::in(['GenericWebhookProcessor', 'TicketWebhookProcessor', 'MailWebhookProcessor']),
            ]
        ]);

        $webhook = new Webhook;
        $webhook->type = $data['type'];
        $webhook->secret = Str::random(40);
        $webhook->user()->associate(Auth::user());
        $webhook->save();
        return $webhook;
    }

    public function storeRule(Webhook $webhook, Request $request)
    {
        $data = $request->validate([
            'type' => [
                'required',
                Rule::in(['Tickets\GenericTicketFieldAction']),
            ],
            'config' => 'json',
            'conditionType' => 'string',
            'conditionValue' => 'string'
        ]);
        $rule = new WebhookRule;
        $rule->config = json_decode($data['config']); ///omg
        $rule->action = $data['type'];
        $rule->webhook_id = $webhook->id;
        if(isset($data['conditionType']))  $rule->condition_type = $data['conditionType'];
        if(isset($data['conditionValue'])) $rule->condition_value = $data['conditionValue'];

        $rule->save();
        return $rule;

    }
}

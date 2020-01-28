<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Webhook;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => [
                'required',
                Rule::in(['GenericWebhookProcessor']),
            ]
        ]);

        $webhook = new Webhook;
        $webhook->type = $data['type'];
        $webhook->secret = Str::random(40);
        $webhook->user()->associate(Auth::user());
        $webhook->save();
        return $webhook;
    }
}

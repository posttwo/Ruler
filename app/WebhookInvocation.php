<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enums\WebhookInvocationStatus;

class WebhookInvocation extends Model
{
    protected $casts = [
        'body' => 'array',
        'head' => 'array'
    ];

    public function webhook()
    {
        return $this->belongsTo('App\Webhook');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebhookRule extends Model
{
    protected $casts = [
        'config' => 'array'
    ];
    
    public function webhook()
    {
        return $this->belongsTo('App\Webhook');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function invocations()
    {
        return $this->hasMany('App\WebhookInvocation');
    }

    public function rules()
    {
        return $this->hasMany('App\WebhookRule');
    }
}

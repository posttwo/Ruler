<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quicklink extends Model
{
    public function webhook()
    {
        return $this->belongsTo('App\Webhook');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ConduitService;

class UtilController extends Controller
{
    public function __construct(ConduitService $conduit){
        $this->conduit = $conduit;
    }

    public function whoami(){
        $result = $this->conduit->callMethodSynchronous('user.whoami', array());
        return $result;
    }
}

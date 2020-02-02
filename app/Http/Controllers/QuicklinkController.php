<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quicklink;

class QuicklinkController extends Controller
{
    public function index()
    {
        return view('quicklink.index');
    }

    public function invoke(Quicklink $quicklink, $any)
    {
        if($any == $quicklink->key)
            return view('quicklink.invoke', ['q' => $quicklink]);
        else
            abort(403);
    }
    
}

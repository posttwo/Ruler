<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Quicklink;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Auth;

class QuicklinkController extends Controller
{
    public function index()
    {
        return Quicklink::orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'webhook_id' => 'required|exists:webhooks,id',
            'key' => 'string|required',
            'title' => 'string|required',
            'text' => 'string|required',
            'preamble' => 'string|nullable'
        ]);

        $q = new Quicklink;
        $q->webhook_id = $data['webhook_id'];
        $q->key = $data['key'];
        $q->title = $data['title'];
        $q->text = $data['text'];
        $q->preamble = $data['preamble'];

        $q->save();
        return $q;

    }

    public function delete(Quicklink $quicklink)
    {
        $quicklink->delete();
        return "No more fish";
    }

    public function view(Quicklink $quicklink)
    {
        $arr = [
            'title' => $quicklink->title,
            'text' => $quicklink->text,
            'preamble' => $quicklink->preamble
        ];
        return $arr;
    }
}

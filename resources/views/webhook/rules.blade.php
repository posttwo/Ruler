@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <store-webhook-rule-component id="{{$id}}"></store-webhook-rule-component>
           <list-webhook-rules-component id="{{$id}}"></list-webhook-rules-component>
        </div>
    </div>
</div>
@endsection

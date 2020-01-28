@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <store-webhook-component></store-webhook-component>
        </div>
    </div>
    
    <list-webhooks-component></list-webhooks-component>
</div>
@endsection

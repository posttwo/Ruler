@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <store-quicklink-component></store-quicklink-component>
            <list-quicklinks-component></list-quicklinks-component>
        </div>
    </div>
    
</div>
@endsection

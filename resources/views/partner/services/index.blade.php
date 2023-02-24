@extends('layouts.main')

@section('content')
    <div class="content">
        <div class="container-fluid" id="app">
            <service-component :institution="{{$institution}}"></service-component>
        </div>
    </div>
@endsection


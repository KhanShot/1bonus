@extends('layouts.main')

@section('content')
    <div id="app" >
        <institution-schedule-component :institution="{{$institution}}"></institution-schedule-component>
    </div>
@endsection


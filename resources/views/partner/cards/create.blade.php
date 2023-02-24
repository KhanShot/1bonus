@extends('layouts.main')

@section('content')

    <div class="content">
        <div class="container-fluid" id="app">
            <cards-create-component :institution="{{$institution}}"></cards-create-component>
        </div>
    </div>
@endsection


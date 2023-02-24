@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">СМС</h1>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>#Mobizon</th>
                        <th>Номер</th>
                        <th>СМС Код</th>
                        <th>Пользователь</th>
                        <th>Тип</th>
                        <th>Дата</th>
                        <th>Подтвержден</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bulks=[] as $bulk)
                        <tr  >
                            <td>{{$bulk->id}}</td>
                            <td>{{$bulk->service_sms_id}}</td>
                            <td>{{$bulk->phone ?? "-"}}</td>
                            <td>{{$bulk->code}}</td>
                            <td>{{$bulk->user->name ?? "-" }}</td>
                            <td>{{$bulk->type}}</td>
                            <td>{{$bulk->created_at}}</td>
                            <td> @if($bulk->verified) <i class="text-success fas fa-check"></i> @else <i class="text-danger fa fa-times"></i> @endif </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

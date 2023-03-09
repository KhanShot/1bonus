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
                        <th>#Id sms</th>
                        <th>Номер</th>
                        <th>СМС Код</th>
                        <th>Статус</th>
                        <th>Тип</th>
                        <th>Дата</th>
                        <th>Подтвержден</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($smsCodes as $sms)
                        <tr  >
                            <td>{{$sms->id}}</td>
                            <td>{{$sms->service_sms_id}}</td>
                            <td>{{$sms->phone ?? "-"}}</td>
                            <td>{{$sms->code}}</td>
                            <td> @if($sms->status == 'not_sent')<i class="fa fa-circle text-danger"></i>@else <i class="fa fa-circle text-success"></i> @endif </td>
                            <td>{{$sms->type}}</td>
                            <td>{{$sms->created_at}}</td>
                            <td> @if($sms->verified) <i class="text-success fas fa-check"></i> @else <i class="text-danger fa fa-times"></i> @endif </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

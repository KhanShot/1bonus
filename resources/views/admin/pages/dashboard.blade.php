@extends('layouts.main', ['pageSlug' => 'dashboard'])

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Кол-во пользователей B2B</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['b2b'] ?? 0}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-business-time fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Посещение
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$data['qr'] ?? 0}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Кол-во пользователей B2C</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['b2c'] ?? 0}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body border-left-primary">
                    <div class="row ml-1">
                        <div class="mr-2">Мужской пол </div> <div> {{$pie['male']}}</div>
                    </div>

                    <div class="row ml-1">
                        <div class="mr-2">Женский пол </div> <div> {{$pie['female']}}</div>
                    </div>
                    <div class="row ml-1">
                        <div class="mr-2">Женат </div> <div> {{$pie['married']}}</div>
                    </div>
                    <div class="row ml-1">
                        <div class="mr-2">Не женат</div> <div> {{$pie['not_married']}}</div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@section('js')

@endsection

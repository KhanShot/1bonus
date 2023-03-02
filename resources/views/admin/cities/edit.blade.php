@extends('layouts.main', ['activePage' => 'table', 'titlePage' => __('Table List')])

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3 mb-4 text-gray-800">Редактировать город: {{ $city->name ?? "-" }}</h1>
        <div>
            <a href="{{route('admin.cities')}}" class="btn btn-success">Назад</a>
        </div>
    </div>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                <form action="{{route('admin.cities.update', $city->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-7 ">
                        <label for="name">Название города</label>
                        <input type="text" required class="form-control" value="{{$city->name}}" name="name" id="name" >
                    </div>
                    <div class="row container-fluid">
                        <div class="form-group">
                            <label for="lat">Широта</label>
                            <input type="text" required class="form-control" value="{{$city->lat}}" name="lat" id="lat" >
                        </div>

                        <div class="form-group ml-4">
                            <label for="long">Долгота</label>
                            <input type="text" required class="form-control" value="{{$city->long}}" name="long" id="long" >
                        </div>
                    </div>

                    <div class="form-group col-md-7 ">
                        <label for="zoomLevel">Приближение</label>
                        <input type="number" required class="form-control" value="{{$city->zoomLevel}}" name="zoomLevel" id="zoomLevel" >
                    </div>
                    <div class="form-group col-md-7 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Редактировать</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection

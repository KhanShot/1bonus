@extends('layouts.main', ['activePage' => 'table', 'titlePage' => __('Table List')])

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3 mb-4 text-gray-800">Создать метку</h1>
        <div>
            <a href="{{route('admin.tags')}}" class="btn btn-success">Назад</a>
        </div>
    </div>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                <form action="{{route('admin.tags.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-5 ">
                        <label for="name">Название метки</label>
                        <input type="text" required class="form-control" name="name" id="name" >
                    </div>
                    <div class="form-group col-md-5 mt-4">
                        <label for="image">Фото</label>
                        <input type="file" accept="image/*" class="form-control-file" required name="image" id="image" style="opacity: 1">
                    </div>
                    <div class="form-group col-md-5 ">
                        <label for="name">Порядковый номер</label>
                        <input type="number" required class="form-control" name="order" id="order" >
                    </div>
                    <div class="form-group col-md-5 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection

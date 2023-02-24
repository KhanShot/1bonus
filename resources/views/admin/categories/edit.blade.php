@extends('layouts.main', ['activePage' => 'table', 'titlePage' => __('Table List')])

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3 mb-4 text-gray-800">Редактировать акцию: {{ $category->name ?? "-" }}</h1>
        <div>
            <a href="{{route('admin.categories')}}" class="btn btn-success">Назад</a>
        </div>
    </div>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                <form action="{{route('admin.categories.update', $category->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-5 ">
                            <label for="name">Название акции *</label>
                            <input type="text" value="{{$category->name}}" required class="form-control" name="name" id="name" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 ">
                            <label for="description">Описание *</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="5">{{$category->description}}</textarea>
                        </div>


                    </div>
                    <div>
                        <div class="form-group col-md-12">
                            <label for="image">Выбрать новое фото</label>
                            <input type="file" accept="image/*" class="form-control-file" name="image" id="image" style="opacity: 1">
                        </div>
                        <div class="form-group col-md-12 mt-4">
                            <label for="image">Старое фото</label>
                            <img src="{{asset('storage'.$category->image)}}" width="400" height="250" alt="">
                        </div>
                    </div>

                    <div class="form-group col-md-5 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


@endsection

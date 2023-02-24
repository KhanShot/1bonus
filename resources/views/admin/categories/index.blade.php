
@extends('layouts.main', ['pageSlug' => 'main'])

@section('content')

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800">Категории</h1>
        <a href="{{route('admin.categories.create')}}" class="btn btn-success"><i class="fa fa-plus"></i></a>
    </div>
    @include('layouts.alert')
    <!-- Tags -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Количество заведений</th>
                        <th>Порядковый номер</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td><img src="{{asset('/storage'.$category->image)}}" width="80" alt=""> </td>
                            <td>{{$category->name ?? "-" }}</td>
                            <td>{{$category->type}}</td>
                            <td>{{$category->created_at}}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning mr-2" href="{{route('admin.categories.edit', $category->id)}}"><i class="fa fa-edit"></i></a>
                                <form action="{{route('admin.categories.delete', $category->id)}}" method="post">@csrf @method('delete')
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

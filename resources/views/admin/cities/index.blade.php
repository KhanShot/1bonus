
@extends('layouts.main', ['pageSlug' => 'main'])

@section('content')

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800">Города</h1>
        <a href="{{route('admin.cities.create')}}" class="btn btn-success"><i class="fa fa-plus"></i></a>
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
                        <th>Координаты</th>
                        <th>Название</th>
                        <th>Количество заведений</th>
                        <th>Количество пользвателей</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td>{{$city->id}}</td>
                            <td>[{{$city->lat .' , '. $city->long}}]</td>
                            <td>{{$city->name ?? "-" }}</td>
                            <td>{{$city->institution_count}}</td>
                            <td>{{ $city->user_count }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning mr-2" href="{{route('admin.cities.edit', $city->id)}}"><i class="fa fa-edit"></i></a>
                                <form action="{{route('admin.cities.delete', $city->id)}}" onsubmit="return confirm('Вы действительно хотите удалить этот город ?');" method="post">@csrf @method('delete')
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

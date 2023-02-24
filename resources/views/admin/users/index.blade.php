
@extends('layouts.main', ['pageSlug' => 'main'])

@section('content')
    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800">Пользователи</h1>
{{--        {{route('admin.users.create')}}--}}
    </div>
    @include('layouts.alert')
    <form>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Город</label>
                            <select class="form-control" name="city">
                                <option value="">Выберите город</option>
                                @foreach($cities as $city)
                                    <option>{{$city}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Категория</label>
                            <select class="form-control" name="category">
                                <option value="">Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Заведения</label>
                            <select class="form-control" name="institution">
                                <option value="">Выберите заведение</option>
                                @foreach($institutions as $institution)

                                    <option>{{$institution->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Пол</label>
                            <select class="form-control" name="gender">
                                <option>Выберите пол</option>
                                <option>Мужской</option>
                                <option>Женский</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">Семейное положение</label>
                            <select class="form-control" name="city">
                                <option value="">Выберите положение</option>
                                <option value="married">Женат/Замужем</option>
                                <option value="not_married">Не женат/Не замужем </option>
                            </select>
                        </div>
                    </div>
                    <div class="d-inline  mr-1">
                        <label for="" class=""><span>&nbsp;</span></label>
                        <div>
                            <button type="submit" value="filter" name="submit" class="btn btn-success mr-2">Фильтр</button>
                            <a  href="{{route('admin.users')}}" class="btn btn-success mr-2">Сбросить фильтр</a>
                            <button type="submit" value="notify" name="submit" class="btn btn-success">Отправить уведомление</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>#</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Пол</th>
                            <th>Дата рождения</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name . ' ' . $user->surname}}</td>
                                <td> {{$user->phone ?? '-'}} </td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->birthday }}</td>
                                <td>
                                    <a href="#" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    <a href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-success"><i class="fa fa-arrow-right"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </form>




@endsection


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
                            <label for="city">Город </label>
                            <select class="form-control" name="city">
                                <option value="">Выберите город</option>
                                @foreach($cities as $city)
                                    <option @if(request()->city == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">Категория</label>
                            <select class="form-control" name="category">
                                <option value="">Выберите категорию</option>
                                @foreach($categories as $category)
                                    <option @if(request()->category == $category->id) selected @endif value="{{$category->id}}" >{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="institution">Заведения</label>
                            <select class="form-control" name="institution">
                                <option value="">Выберите заведение</option>
                                @foreach($institutions as $institution)
                                    <option value="{{$institution->id}}" @if(request()->institution == $institution->id) selected @endif >{{$institution->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gender">Пол</label>
                            <select class="form-control" name="gender">
                                <option value="">Выберите пол</option>
                                <option value="m" @if(request()->gender == 'm') selected @endif >Мужской</option>
                                <option value="f" @if(request()->gender == 'f') selected @endif>Женский</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="married">Семейное положение</label>
                            <select class="form-control" name="married">
                                <option value="">Выберите положение</option>
                                <option @if(request()->married == '1') selected @endif value="1">Женат/Замужем</option>
                                <option @if(request()->married == '0') selected @endif value="0">Не женат/Не замужем </option>
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
                                <td><input name="user_ids[]" value="{{$user->id}}" type="checkbox"></td>
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

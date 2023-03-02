@extends('layouts.main')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800">Заведении</h1>
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
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Владелец</th>
                        <th>Город</th>
                        <th>Соц сети</th>
                        <th>Дата регистрации</th>
                        <th>Тэги</th>
                        <th>Действие</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($institutions as $institution)
                        <tr>
                            <td>{{$institution->id}}</td>
                            <td>{{$institution->name ?? "-" }}</td>
                            <td>{{$institution->category ? $institution->category->name : '-' }}</td>
                            <td>{{$institution->owner ? $institution->owner->name : '-' }}</td>
                            <td>{{$institution->address ? $institution->address->city : '-' }}</td>
                            <td class="d-flex justify-content-around pl-4 pr-4">@if($institution->insta)<div><a target="_blank" href="{{$institution->insta}}"><i class="fa-brands fa-instagram"></i></a></div>@endif
                                @if($institution->telegram)<div><a target="_blank" href="https://t.me/{{$institution->telegram}}"><i class="fa-brands fa-telegram"></i></a></div>@endif
                                @if($institution->whatsapp)<div><a target="_blank" href="https://wa.me/{{$institution->whatsapp}}"><i class="fa-brands fa-whatsapp"></i></a></div>@endif</td>
                            <td>{{$institution->created_at }}</td>
                            <td>
                                <?php $i = 0; ?>

                                @foreach($institution->tags as $tag)
                                    {{ $tag->name }}
                                    @if(++$i == count($institution->tags))
                                    @else
                                        ,
                                    @endif
                                @endforeach
                            </td>

                            <td class="d-flex">
                                <a class="btn btn-warning mr-2" href="{{route('admin.institutions.edit', $institution->id)}}"><i class="fa fa-edit"></i></a>
                                <button class="btn btn-success mr-2 " data-toggle="modal" data-target="#tag_modal{{$institution->id}}"><i class="fa fa-tag"></i></button>

                                <!-- Modal -->
                                <div class="modal fade" id="tag_modal{{$institution->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Тэги</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{route('admin.institutions.addTag')}}">
                                                    @csrf
                                                    <input type="hidden" name="institution_id" value="{{$institution->id}}">
                                                    @foreach($tags as $tag)

                                                    <div class="form-group">
                                                        <input type="checkbox" name="tags[]" value="{{$tag->id}}"
                                                               @if(count($tag->institution) > 0)
                                                                   @foreach($tag->institution as $tins)
                                                                       @if($institution->id == $tins->id) checked @endif
                                                                   @endforeach
                                                               @endif

                                                               class="custom-checkbox" id="tag_{{$institution->id}}_{{$tag->id}}">
                                                        <label for="tag_{{$institution->id}}_{{$tag->id}}">{{$tag->name}}</label>
                                                    </div>
                                                    @endforeach
                                                    <hr>
                                                    <div class="form-group d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-success">Сохранить</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <form action="{{route('admin.institutions.delete', $institution->id)}}" method="post">@csrf @method('delete')
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

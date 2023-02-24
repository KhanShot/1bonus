
@extends('layouts.main', ['pageSlug' => 'main'])

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Главная</h1>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Баннеры</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Категории и метки</button>
         </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-end mb-4">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bannerModal"><i class="fa fa-plus"></i></button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="bannerModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bannerModalLabel">Добавить баннер</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('admin.banners.store')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div>
                                                Выберите заведение, которое хотите прорекламировать либо укажите ссылку куда должен вести банер
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="institution">Заведение</label>
                                                <select name="institution" id="institution" class="form-control">
                                                    <option value="">Выбрать заведение</option>
                                                    @foreach($institutions as $institution)
                                                        <option value="{{$institution->id}}">{{$institution->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="link">Ссылка</label>
                                                <input type="text" name="link" id="link" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="title">Заголовок</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Добавить картинку</label>
                                                <input type="file" accept="image/*" name="image" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="order">Порядковый номер</label>
                                                <input type="number" name="order" class="form-control" required>
                                            </div>
                                            <div class="form-group d-flex justify-content-enda">
                                                <button type="submit" class="btn btn-success">Создать</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBannerModalLabel">New message</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{route('admin.banners.update')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="banner">
                                            <div>
                                                Выберите заведение, которое хотите прорекламировать либо укажите ссылку куда должен вести банер
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="institution_edit">Заведение</label>
                                                <select name="institution" id="institution_edit" class="form-control">
                                                    <option value="">Выбрать заведение</option>
                                                    @foreach($institutions as $institution)
                                                        <option value="{{$institution->id}}">{{$institution->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="link_edit">Ссылка</label>
                                                <input type="text" name="link" id="link_edit" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="title">Заголовок</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">Добавить картинку  <span><a href="#" target="_blank">открыть фото</a></span> </label>
                                                <input type="file" accept="image/*" name="image" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="order">Порядковый номер</label>
                                                <input type="number" name="order" class="form-control" required>
                                            </div>

                                            <div class="form-group d-flex justify-content-end">
                                                <button class="btn btn-success" type="submit">Редактировать</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Заведение</th>
                                <th>Фото</th>
                                <th>Заголовок</th>
                                <th>Ссылка</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{$banner->order}}</td>
                                    <td>{{$banner->institution ? $banner->institution->name : '-' }}</td>
                                    <td><img src="{{asset( '/storage'.$banner->image )}}" width="80"></td>
                                    <td>{{$banner->title}}</td>
                                    <td>{{$banner->link ?? '-'}}</td>
                                    <td class="d-flex">
                                        <form method="post" action="{{route('admin.banners.delete', $banner->id)}}">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>

                                        </form>
                                        <button type="button" class="btn btn-warning ml-2"
                                                data-toggle="modal" data-target="#editBannerModal"
                                                data-title="{{$banner->title}}"
                                                data-image="{{$banner->image}}"
                                                data-order="{{$banner->order}}"
                                                data-banner_id="{{$banner->id}}"
                                                data-link="{{$banner->link ?? ''}}"
                                                data-institution="{{ $banner->institution_id ?? '' }}"
                                        ><i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Категория и метки</th>
                                <th>Категория или метка</th>
                                <th>Кол-во заведение</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{$tag->order}}</td>
                                    <td>{{$tag->name}}</td>
                                    <td>Метка</td>
                                    <td>{{$tag->institution_count}}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('admin.tags.delete', $tag->id)}}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <button data-toggle="modal" data-target="#editTagsModal" class="btn btn-warning"><i class="fa fa-edit"></i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editTagsModal" tabindex="-1" role="dialog" aria-labelledby="editTagsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editTagsModalLabel">Редактировать категорию</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.tags.updateMain', $tag->id)}}" method="post" >
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="name">Название метки </label>
                                                                <input type="text" value="{{$tag->name}}" required class="form-control" name="name" id="name" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="order">Порядковый номер </label>
                                                                <input type="text" value="{{$tag->order}}" required class="form-control" name="order" id="order" >
                                                            </div>

                                                            <div class="form-group mt-4 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-success">Сохранить</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->order}}</td>
                                    <td> {{$category->name}} </td>
                                    <td>Категория</td>
                                    <td> {{$category->institution_count}}</td>
                                    <td class="d-flex">
                                        <form action="{{ route('admin.categories.delete', $category->id)}}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <button data-toggle="modal" data-target="#editCategoryModal" class="btn btn-warning"><i class="fa fa-edit"></i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editCategoryModalLabel">Редактировать категорию</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.categories.updateMain', $category->id)}}" method="post" >
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="name">Название категории </label>
                                                                <input type="text" value="{{$category->name}}" required class="form-control" name="name" id="name" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="order">Порядковый номер </label>
                                                                <input type="text" value="{{$category->order}}" required class="form-control" name="order" id="order" >
                                                            </div>

                                                            <div class="form-group mt-4 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-success">Сохранить</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
    <script>
        $('#institution').on('change', function () {
            if($('#institution').val() === ''){
                $("#link").removeAttr('disabled')

            }else{
                $("#link").val('')
                $("#link").attr('disabled', true)

            }
        });

        $('#institution_edit').on('change', function () {
            if($('#institution_edit').val() === ''){
                $("#link_edit").removeAttr('disabled')

            }else{
                $("#link_edit").val('')
                $("#link_edit").attr('disabled', true)

            }
        });

        $('#editBannerModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)
            let title = button.data('title')
            let image = button.data('image')
            let link = button.data('link')
            let order = button.data('order')
            let institution = button.data('institution')
            let banner = button.data('banner_id')

            let modal = $(this)
            modal.find('.modal-body input[name="title"]').val(title)
            modal.find('.modal-body input[name="order"]').val(order)
            modal.find('.modal-body input[name="link"]').val(link)
            modal.find('.modal-body a').attr('href', '/storage' + image )
            modal.find('.modal-body input[name="banner"]').val(banner)

            if(institution){
                modal.find('.modal-body select').val(institution)
                modal.find('.modal-body input[name="link"]').attr('disabled', true)
            }else{
                modal.find('.modal-body select').val('')
                modal.find('.modal-body input[name="link"]').removeAttr('disabled')
            }
        })
    </script>
@endsection

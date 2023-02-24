@extends('layouts.main', ['activePage' => 'table', 'titlePage' => __('Table List')])

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Информация</h1>
    @include('layouts.alert')
    <!-- DataTales Example -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <style>
        svg{
            vertical-align: unset;
        }
        .mult-select-tag .item-container{
            border: 1px solid #4e73df;
            background: #99e4f1;

        }
    </style>
    <div class="content">

        <div class="container-fluid" >
            <div class="">
                <div class="card">
                    <div class="card-header">
                        {{$institution ? 'Редактировать: '. $institution->name : 'Добавить заведения' }}
                    </div>
                    <div class="card-body">
                        <form action="{{ $institution ? route('partner.institution.update', $institution->id) : route('partner.institution.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Название</label>
                                        <input type="text" name="name" value="{{ $institution->name ?? old('name')}}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Описание</label>
                                        <textarea name="description" rows="3" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $institution->description ?? old('description')}}</textarea>
                                        @include('alerts.feedback', ['field' => 'description'])
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Изображение {!!  $institution ? '<a href="/storage'. $institution->image .'" target="_blank"> открыть </a>' : '' !!} </label>
                                        <input type="file" accept="image/*" name="image" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'image'])
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Лого {!!  $institution ? '<a href="/storage'. $institution->logo .'" target="_blank"> открыть </a>' : '' !!}</label>
                                        <input type="file" accept="image/*" name="logo" class="form-control{{ $errors->has('logo') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'logo'])
                                    </div>

                                    <div class="form-group">
                                        <label for="full_address">Адрес</label>
                                        <?php
                                        function full_address_error($errors){
                                            if ($errors->has('full_address') || $errors->has('long') || $errors->has('lat')
                                                || $errors->has('premiseNumber') || $errors->has('street') || $errors->has('city') )
                                                return true;
                                            return false;
                                        }
                                        ?>
                                        <input type="text" class="form-control{{ full_address_error($errors) ? ' is-invalid' : '' }}" value="{{ $institution->address->full_address ?? old('full_address')}}" name="full_address" id="full_address" />
                                        @include('alerts.feedback', ['field' => 'full_address'])

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Телефон номер</label>
                                        <input type="text" name="phone" id="wash-phone" value="{{ $institution->phones[0]->phone ?? old('phone')}}" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'phone'])
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Категория</label>
                                        <select name="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => 'category'])

                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label for="">Тэги</label>--}}
{{--                                        <select name="tags" class="form-control{{ $errors->has('tags') ? ' is-invalid' : '' }}">--}}
{{--                                            @foreach($tags as $tag)--}}
{{--                                                    <?php $tagSelected = false; ?>--}}
{{--                                                @if($institution)--}}
{{--                                                    @foreach($institution->tags as $institutionTag)--}}
{{--                                                        @if($tag->id == $institutionTag->tag_id)--}}
{{--                                                                <?php $tagSelected = true; ?>--}}
{{--                                                        @endif--}}
{{--                                                    @endforeach--}}
{{--                                                @endif--}}

{{--                                                <option @if($tagSelected) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>--}}

{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @include('alerts.feedback', ['field' => 'tags'])--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <label for="insta">Instagram (только ваш логин) https://instagram.com/</label>
                                        <input type="text" name="insta"  value="{{ $institution->insta ?? old('insta')}}" class="form-control{{ $errors->has('insta') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'insta'])
                                    </div>

                                    <div class="form-group">
                                        <label for="telegram">Telegram (только ваш логин) https://t.me/</label>
                                        <input type="text" name="telegram"  value="{{ $institution->telegram ?? old('telegram')}}" class="form-control{{ $errors->has('telegram') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'telegram'])
                                    </div>

                                    <div class="form-group">
                                        <label for="whatsapp">WhatsApp номер https://wa.me/</label>
                                        <input type="text" name="whatsapp" id="wash-phone-whatsApp" value="{{ $institution->whatsapp ?? old('whatsapp')}}" class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }}">
                                        @include('alerts.feedback', ['field' => 'whatsapp'])
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <input type="hidden" id="long" name="long" value="{{ $institution->address->long ?? old('long')}}" >
                                <input type="hidden" id="lat" name="lat" value="{{ $institution->address->lat ?? old('lat')}}">
                                <input type="hidden" id="city" name="city" value="{{ $institution->address->city ?? old('city')}}">
                                <input type="hidden" id="street" name="street" value="{{ $institution->address->street ?? old('street')}}">
                                <input type="hidden" id="premiseNumber" name="premiseNumber" value="{{ $institution->address->premiseNumber ?? old('premiseNumber')}}">
                                <div id="map" style="max-width: 600px; height: 400px"></div>

                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Сохранить</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
        new MultiSelectTag('multiselectTag')
        let phoneMask = IMask(
            document.getElementById('wash-phone'), {
                mask: '+{7}(000)000-00-00'
            });
        let phoneMaskWhatsApp = IMask(
            document.getElementById('wash-phone-whatsApp'), {
                mask: '{7}7000000000'
            });
    </script>

    <script>
        $(document).ready(function(){
            ymaps.ready(init);
            let address_input = $("#full_address");
            function init() {
                let  myInput = document.getElementById("address"),
                    myPlacemark,
                    myMap = new ymaps.Map('map', {
                        center: [43.237288506741315, 76.92540025903315],
                        zoom: 13,
                        controls: []
                    });
                myMap.controls.add('zoomControl', {
                    size: "large"
                });
                var searchControl = new ymaps.control.SearchControl({
                    options: {
                        provider: 'yandex#search',
                        placemark: false
                    }
                });

                // Добавим поиск на карту
                myMap.controls.add(searchControl);

                // Нужное нам событие (выбор результата поиска)
                searchControl.events.add('resultselect', function(e) {
                    var index = e.get('index');
                    searchControl.getResult(index).then(function(res) {
                        let coords = res.geometry.getCoordinates();
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        getAddress(res.geometry.getCoordinates())

                    });
                });


                if($("#long").val() != ''){
                    myPlacemark = createPlacemark([$("#long").val(), $("#lat").val()]);
                    myMap.geoObjects.add(myPlacemark);

                    getAddress([$("#long").val(), $("#lat").val()]);
                }


                // Слушаем клик на карте.
                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');

                    // Если метка уже создана – просто передвигаем ее.
                    if (myPlacemark) {
                        myPlacemark.geometry.setCoordinates(coords);
                    }
                    // Если нет – создаем.
                    else {
                        myPlacemark = createPlacemark(coords);
                        myMap.geoObjects.add(myPlacemark);
                        // Слушаем событие окончания перетаскивания на метке.
                        myPlacemark.events.add('dragend', function () {
                            getAddress(myPlacemark.geometry.getCoordinates());
                        });
                    }
                    getAddress(coords);
                });
                // Создание метки.
                function createPlacemark(coords) {
                    return new ymaps.Placemark(coords, {
                        iconCaption: 'поиск...'
                    }, {
                        preset: 'islands#violetDotIconWithCaption',
                        draggable: true
                    });
                }
                // Определяем адрес по координатам (обратное геокодирование).
                function getAddress(coords) {
                    myPlacemark.properties.set('iconCaption', 'поиск...');
                    ymaps.geocode(coords).then(function (res) {
                        var firstGeoObject = res.geoObjects.get(0),
                            address = firstGeoObject.getAddressLine();
                        address_input.val(firstGeoObject.getAdministrativeAreas() + ", " + firstGeoObject.getThoroughfare() + ", " + firstGeoObject.getPremiseNumber());
                        $("#city").val(firstGeoObject.getAdministrativeAreas());
                        $("#street").val(firstGeoObject.getThoroughfare());
                        $("#premiseNumber").val(firstGeoObject.getPremiseNumber());

                        $('#address').val()
                        $("#long").val(coords[0]);
                        $("#lat").val(coords[1]);
                        myPlacemark.get
                        myPlacemark.properties
                            .set({
                                // Формируем строку с данными об объекте.
                                iconCaption: [
                                    // Название населенного пункта или вышестоящее административно-территориальное образование.
                                    firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                    // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                    firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                                ].filter(Boolean).join(', '),

                            });
                    });
                }
            }
        });
    </script>

@endsection

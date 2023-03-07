@extends('layouts.main')

@section('content')
    <style>
        select option {
            margin: 40px;
            background: #27293d;
            color: #fff;
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
        }
        .c-card{
            background: #4e73df;
            border: 0;
            border-radius: 5px;
            box-shadow: 0 1px 20px 0px rgb(0 0 0 / 10%);
            min-width: 5rem;
        }
    </style>
    <div class="content">
        <div class="container-fluid" id="app">
            @include("layouts.alert")
            <div>
                <div class="d-flex justify-content-end">
                    <a href="{{route('partner.cards.create')}}" class="btn btn-success" >создать карточку</a>
                </div>

                @foreach($institutionCards as $key => $cards)
                    <div class="mt-5">
                        <div class="heading mt-2 d-flex">
                            <div>
                                <div>Карта: {{$key}}</div>
                                <div>Дата: {{$cards[0]->created_at}}</div>
                            </div>

                            <div class="ml-5">
                                <form
                                      @if($cards[0]->deleted_at) action="{{route('partner.cards.forceDelete', $key)}}" @else action="{{route('partner.cards.delete', $key)}}" @endif
                                      method="POST" onsubmit="return confirm('Вы действительно хотите удалить карточку посещение?');"> @csrf @method('delete')
                                    <button class="bg-transparent border-0" style="color: #4e73df" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="mt-3">
                            @foreach($cards as $card)
                                <div class='c-card p-2 d-inline-block mb-2 mr-2 text-center @if($card->deleted_at)bg-gray-600 @endif'>
                                    <div class="text-white"> {{$card->visit}}</div>
                                    <div class="text-white" style="">{{$card->bonus_name ?? "-"}}</div>
                                </div>
                            @endforeach
                        </div>
                        @if($loop->first)
                            <hr>
                        @endif
                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection


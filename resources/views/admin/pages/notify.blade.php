@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Отправить уведомление ( {{ count(request()->get('user_ids'))  }} юзер)</h5>
                </div>
                <form method="post" action="{{ route('admin.notification.send') }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="user_ids" value="{{ serialize(request()->get('user_ids')) }}" >
                        <div class="form-group">
                            <label>{{ __('Заголовок') }}</label>
                            <input type="text" required name="header" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Текст</label>
                            <textarea required rows="4" class="form-control" name="text" ></textarea>
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Отправить') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

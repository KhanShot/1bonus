<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\User;
use App\Models\UsersFcmToken;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    use TJsonResponse;
    public function index(Request $request){
        $users = $request->get('user_ids');

        if (!$users)
            return redirect()->route('admin.users')->with('error', 'Выберите пользователей!');
        return view('admin.pages.notify');
    }


    public function send(Request $request){


        $user_ids = unserialize($request->get('user_ids'));

        $fcm_tokens = UsersFcmToken::query()->whereIn('user_id', $user_ids)->get()->pluck('token');

        $data = array(
            'header' => $request->get('header'),
            'text' => $request->get('text'),
            'fcm_tokens' => $fcm_tokens,
            'data' => null
        );

        $users = User::query()->whereIn('id',$user_ids)->get();

        Notification::send($users ,new AdminNotification($data));

        $this->sendNotification($data);

        return redirect()->route('admin.users')->with('success', 'Уведомление отправлено!');

    }
}

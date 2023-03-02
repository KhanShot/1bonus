<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\User;
use App\Models\UsersFcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use TJsonResponse;
    public function login(LoginRequest $request){
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)){

            $user = User::query()->find(\auth()->user()->id);

            $data['user'] = $user;
            $data['token'] = $user->createToken("API token")->plainTextToken;

            UsersFcmToken::query()->where('user_id', $user->id )->delete();
            UsersFcmToken::query()->create([
                'user_id' => $user->id,
                'token' => $request->get('fcm_token'),
            ]);

            return $this->successResponse(Utils::$MESSAGE_AUTHENTICATED,$data);

        }else{
            return $this->failedResponse(Utils::$MESSAGE_LOGIN_INCORRECT,400);
        }
    }


    public function unauthorized(){
        return $this->failedResponse('unauthorized', 401);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SendSmsRequest;
use App\Http\Requests\Api\VerifyPhoneRequest;
use App\Http\Services\SendSmsService;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\SmsCodes;
use App\Models\User;
use App\Models\UsersFcmToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use TJsonResponse;
    public function login(LoginRequest $request){
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)){

            $user = User::query()->find(\auth()->user()->id);

            $data['user'] = $user;
            if ($user->name == '')
                $data['user'] = null;
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


    public function send(SendSmsRequest $request, SendSmsService $service){

        $sendCode = $service->sendSms($request, 'register');
//        return $sendCode;
        if (!$sendCode)
            return $this->failedResponse(Utils::$MESSAGE_SMS_NOT_SENT, 400);

        return $this->successResponse(Utils::$MESSAGE_VERIFY_PHONE_SEND);

    }

    public function verify(VerifyPhoneRequest $request){

        $bulk = SmsCodes::query()->where("phone", $request->get("phone") )
            ->where("code", $request->get("code"))
            ->where("verified", 0)->first();

        if (!$bulk)
            return $this->failedResponse(Utils::$MESSAGE_PHONE_VERIFIED_ALREADY, 400,
                null, 'code_already_used');


        $data = [
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'phone_verified_at' => now(),
            'type' => 'user',
            'name' => '',
        ];


        $user = User::query()->create($data);

        $bulk->verified = 1;
        $user->verified_at = now();

        $bulk->save();
        UsersFcmToken::query()->where('user_id', $user->id )->delete();
        UsersFcmToken::query()->create([
            'user_id' => $user->id,
            'token' => $request->get('fcm_token'),
        ]);

        $token = $user->createToken("API token")->plainTextToken;

        $data['token'] = $token;
        $data['user'] = $user;
        return $this->successResponse(Utils::$MESSAGE_PHONE_VERIFIED, $data);

    }



}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PasswordCheckRequest;
use App\Http\Requests\Api\PasswordSendRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SendSmsRequest;
use App\Http\Requests\Api\VerifyPasswordRequest;
use App\Http\Services\SendSmsService;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\SmsCodes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    use TJsonResponse;
    public function check(PasswordCheckRequest $request, SendSmsService $service){
        $sendCode = $service->sendSms($request, 'password');

        if (!$sendCode)
            return $this->failedResponse(Utils::$MESSAGE_SMS_NOT_SENT, 400);

        return $this->successResponse(Utils::$MESSAGE_VERIFY_PHONE_SEND);
    }


    public function verify(VerifyPasswordRequest $request){
        $bulk = SmsCodes::query()->where("phone", $request->get("phone") )
            ->where("code", $request->get("code"))
            ->where('type', 'password')
            ->where("verified", 0)->first();

        if (!$bulk)
            return $this->failedResponse(Utils::$MESSAGE_USED_SMS_CODE, 400,
                null, 'code_already_used');

        $bulk->verified = 1;
        $bulk->save();
        return $this->successResponse(Utils::$MESSAGE_PHONE_VERIFIED);
    }

    public function reset(ResetPasswordRequest $request){
        $user = User::query()->where('phone', $request->get('phone'))
            ->first();

        $user->password = Hash::make($request->get('password'));
        $user->save();
        return $this->successResponse(Utils::$MESSAGE_SUCCESS_UPDATED);
    }

}

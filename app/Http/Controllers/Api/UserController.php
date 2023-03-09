<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Cities;
use App\Models\Favourite;
use App\Models\User;
use App\Models\UserCards;
use App\Models\UsersFcmToken;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use TJsonResponse;
    public function getProfile(){
        $user = User::query()->with('city')->find(auth()->user()->id);
        return $this->successResponse(null, $user);
    }

    public function update(UpdateUserRequest $request){

        $data = $request->validated();
        $data['city_id'] = $request->get('city');
        $user = User::query()->find(auth()->user()->id);

        $user->update($data);

        return $this->successResponse(Utils::$MESSAGE_SUCCESS_UPDATED);
    }

    public function getCity(){
        return Cities::query()->find(auth()->user()->city_id) ?? null;
    }

    public function delete(){
        UserCards::query()->where('user_id', auth()->user()->id)->delete();
        UsersFcmToken::query()->where('user_id', auth()->user()->id)->delete();
        Favourite::query()->where('user_id', auth()->user()->id)->delete();
        $user = User::query()->find(auth()->user()->id);
        $user->notifcations()->delete();
        $user->delete();
    }

}

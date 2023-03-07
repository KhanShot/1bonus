<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Institution;
use App\Models\InstitutionAddress;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request){
        $users = User::query()->where('type', 'user');
        $institutions = Institution::query()->get();
        $categories = Categories::query()->get();
        $cities = Cities::query()->get();


        if (!is_null($request->get('city'))){
            $users = $users->where('city_id', $request->get('city'));
        }
        if (!is_null($request->get('gender'))){
            $users = $users->where('gender', $request->get('gender'));
        }

        if (!is_null($request->get('married'))){

        }

        if (!is_null($request->get('institution'))){
            $u_plucks = UserCards::query()->where('institution_id', $request->get('institution'))->pluck('user_id');
            $arr = $u_plucks->unique();

            $users = $users->whereIn('id', $arr);
        }

        if (!is_null($request->get('category'))) {
            $inst_arr = Institution::query()->where('category_id', $request->get('category'))
                ->pluck('id');

            $user_p = UserCards::query()->whereIn('institution_id', $inst_arr)->pluck('user_id')->unique();

            $users = $users->whereIn('id', $user_p);
        }

        if ($request->get('submit') == 'notify'){
            if (!$request->has('user_ids'))
                return redirect()->route('admin.users')->with('error', 'Выберите пользователей!');

            $user_ids = $request->get('user_ids');
            return redirect()->route('admin.notification', compact('user_ids'));
        }


        $users = $users->get();
        return view('admin.users.index', compact('users', 'institutions', 'categories', 'cities'));
    }
}

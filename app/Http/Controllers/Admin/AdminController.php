<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categories;
use App\Models\Institution;
use App\Models\Tags;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard(){
//        $users = User::query();
        $data['b2b'] = User::query()->where('type', 'partner')->count();
        $data['b2c'] = User::query()->where('type', 'user')->count();
        $data['qr'] = UserCards::query()->get()->unique('group')->count();


//        dd($users->where('type', 'user')->count());

        $pie['male'] = User::query()->where('type', 'user')->where('gender', 'm')->count();
        $pie['female'] = User::query()->where('type', 'user')->where('gender', 'f')->count();
        $pie['married'] = User::query()->where('type', 'user')->where('married', 1)->count();
        $pie['not_married'] = User::query()->where('type', 'user')->where('married', 0)->count();


        return view('admin.pages.dashboard', compact('data', 'pie'));
    }

    public function main(){
        $institutions = Institution::query()->get();
        $banners = Banner::with('institution')->get();
        $categories = Categories::query()->withCount('institution')->get();
        $tags = Tags::query()->withCount('institution')->get();

        return view('admin.pages.main', compact('institutions', 'banners', 'categories', 'tags'));
    }
}

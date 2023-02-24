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
        $users = User::query();
        $data['b2b'] = $users->where('type', 'partner')->count();
        $data['b2c'] = $users->where('type', 'user')->count();
        $data['qr'] = UserCards::query()->get()->unique('group')->count();

        return view('admin.pages.dashboard', compact('data'));
    }

    public function main(){
        $institutions = Institution::query()->get();
        $banners = Banner::with('institution')->get();
        $categories = Categories::query()->withCount('institution')->get();
        $tags = Tags::query()->withCount('institution')->get();

        return view('admin.pages.main', compact('institutions', 'banners', 'categories', 'tags'));
    }
}

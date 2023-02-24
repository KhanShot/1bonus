<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Institution;
use App\Models\InstitutionAddress;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        $users = User::query()->where('type', 'user')->get();
        $institutions = Institution::query()->get();
        $categories = Categories::query()->get();
        $cities = InstitutionAddress::query()->pluck('city');
        return view('admin.users.index', compact('users', 'institutions', 'categories', 'cities'));
    }
}

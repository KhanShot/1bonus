<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(){
        return view('admin.pages.profile_edit');
    }

    public function update(Request $request){
        return back()->with('success', 'Профиль обновлена!');
    }

    public function password(Request $request){
        return back()->with('success', 'Профиль обновлена!');
    }
}

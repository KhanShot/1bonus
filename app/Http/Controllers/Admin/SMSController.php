<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsCodes;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function index(){
        $smsCodes = SmsCodes::query()
            ->get();

        return view('admin.pages.sms', compact('smsCodes'));
    }
}

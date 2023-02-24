<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function index(){
        return view('admin.pages.sms');
    }

    public function gtp(){
        return view('admin.pages.gpt');
    }
}

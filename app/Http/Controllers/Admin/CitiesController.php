<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Utils;
use App\Models\Cities;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function index(){
        $cities = Cities::query()
            ->withCount('institution')
            ->withCount('user')
            ->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function create(){
        return view('admin.cities.create');
    }

    public function store(Request $request){
        Cities::query()->create([
            'name' => $request->get('name'),
            'lat' => $request->get('lat'),
            'long' => $request->get('long'),
            'zoomLevel' => $request->get('zoomLevel'),
        ]);

        return redirect()->route('admin.cities')->with('success', Utils::$MESSAGE_SUCCESS_ADDED);
    }

    public function edit($city_id){
        $city = Cities::query()->find($city_id);
        if (!$city)
            return redirect()->route('admin.cities')->with('error',Utils::$MESSAGE_DATA_NOT_FOUND);

        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, $city_id){
        $city = Cities::query()->find($city_id);
        if (!$city)
            return redirect()->route('admin.cities')->with('error',Utils::$MESSAGE_DATA_NOT_FOUND);

        $city->update([
            'name' => $request->get('name'),
            'lat' => $request->get('lat'),
            'long' => $request->get('long'),
            'zoomLevel' => $request->get('zoomLevel'),
        ]);

        return redirect()->route('admin.cities')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);
    }

    public function delete($city_id){
        $city = Cities::query()->find($city_id);
        if (!$city)
            return redirect()->route('admin.cities')->with('error',Utils::$MESSAGE_DATA_NOT_FOUND);

        $city->delete();

        return redirect()->route('admin.cities')->with('success', Utils::$MESSAGE_SUCCESS_DELETED);
    }
}

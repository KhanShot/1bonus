<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Utils;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function store(Request $request){
        $data = array(
            'title' => $request->get('title'),
            'order' => $request->get('order'),
            'link' => $request->get('link'),
            'institution_id' => $request->get('institution'),
        );

        if ($request->hasFile("image")){
            $path = "/assets/banners";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }

        Banner::query()->create($data);
        return redirect()->route('admin.main')->with('success', Utils::$MESSAGE_SUCCESS_ADDED);
    }

    public function delete($banner_id){
        $banner = Banner::query()->find($banner_id);
        if (!$banner)
            return redirect()->route('admin.main')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        Storage::delete("public". $banner->image);

        $banner->delete();
        return redirect()->route('admin.main')->with('success', Utils::$MESSAGE_SUCCESS_DELETED);


    }

    public function update(Request $request){
        if (!$request->get('banner'))
            return back()->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        $banner = Banner::query()->find($request->get('banner'));

        $data = array(
            'title' => $request->get('title'),
            'order' => $request->get('order'),
            'link' => $request->get('link'),
            'institution_id' => $request->get('institution'),
        );


        if ($request->hasFile("image")){
            Storage::delete("public". $banner->image);
            $path = "/assets/banners";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }

        $banner->update($data);

        return redirect()->route('admin.main')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);

    }

}

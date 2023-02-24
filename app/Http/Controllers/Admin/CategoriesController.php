<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Utils;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Categories::query()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }
    public function edit($cat_id){
        $category = Categories::query()->find($cat_id);
        if (!$category)
            return redirect()->route('admin.categories')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);
        return view('admin.categories.edit',compact('category'));
    }

    public function store(Request $request){
        $data = array(
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        );
        if ($request->hasFile("image")){
            $path = "/assets/categories";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }

        Categories::query()->create($data);

        return redirect()->route('admin.categories')->with('success', Utils::$MESSAGE_SUCCESS_ADDED);
    }

    public function update($cat_id, Request $request){
        $category = Categories::query()->find($cat_id);
        if (!$category)
            return redirect()->route('admin.categories')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);
        $data = array(
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        );
        if ($request->hasFile("image")){
            Storage::delete("public". $category->image);
            $path = "/assets/stocks";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }

        $category->update($data);
        return redirect()->route('admin.categories')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);

    }

    public function updateMain(Request $request, $cat_id){
        $category = Categories::query()->find($cat_id);
        if (!$category)
            return redirect()->route('admin.main')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        $category->update([
            'name' => $request->get('name'),
            'order' => $request->get('order'),
        ]);
        return redirect()->route('admin.main')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);

    }

    public function delete($cat_id){
        $category = Categories::query()->find($cat_id);
        if (!$category)
            return redirect()->route('admin.categories')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        Storage::delete("public". $category->image);
        $category->delete();
        return redirect()->back()->with('success', Utils::$MESSAGE_SUCCESS_DELETED);

    }


}

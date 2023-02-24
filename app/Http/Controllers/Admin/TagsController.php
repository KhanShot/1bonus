<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagStoreRequest;
use App\Http\Requests\Admin\TagUpdateRequest;
use App\Http\Traits\Utils;
use App\Models\Categories;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TagsController extends Controller
{

    public function index(){
        $tags = Tags::query()->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create(){
        return view("admin.tags.create");
    }

    public function edit($tag_id){
        $tag = Tags::query()->find($tag_id);
        if (!$tag)
            return redirect()->route('admin.tags')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);
        return view('admin.tags.edit',compact('tag'));
    }

    public function store(TagStoreRequest $request){
        $data = $request->validated();
        if ($request->hasFile("image")){
            $path = "/assets/tags";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }

        Tags::query()->create($data);
        return redirect()->route('admin.tags')->with('success', Utils::$MESSAGE_SUCCESS_ADDED);
    }

    public function update(TagUpdateRequest $request, $tag_id){
        $tag = Tags::query()->find($tag_id);
        if (!$tag)
            return redirect()->route('admin.tags')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        $data = $request->validated();
        if ($request->hasFile("image")){
            $path = "/assets/tags";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }
        $tag->update($data);
        return redirect()->route('admin.tags')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);

    }

    public function updateMain(Request $request, $tag_id){
        $tag = Tags::query()->find($tag_id);
        if (!$tag)
            return redirect()->route('admin.main')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        $tag->update([
            'name' => $request->get('name'),
            'order' => $request->get('order'),
        ]);
        return redirect()->route('admin.main')->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);

    }

    public function delete($tag_id){
        $tag = Tags::query()->find($tag_id);
        if (!$tag)
            return redirect()->route('admin.tags')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        Storage::delete("public". $tag->image);
        $tag->delete();
        return redirect()->back()->with('success', Utils::$MESSAGE_SUCCESS_DELETED);

    }



}

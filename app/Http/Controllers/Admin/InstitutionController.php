<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Utils;
use App\Models\Categories;
use App\Models\Institution;
use App\Models\InstitutionTags;
use App\Models\Tags;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(){
        $institutions = Institution::with(['address', 'category', 'owner', 'tags'])->get();
        $tags = Tags::with(['institution'])->get();
        return view('admin.institution.index', compact('institutions', 'tags'));
    }

    public function edit($ins_id){
        $institution = Institution::with(['address', 'phones'])->find($ins_id);
        if(!$institution)
            return redirect()->route('admin.institution')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);
        $categories = Categories::query()->get();
        return view('admin.institution.edit', compact('institution', 'categories'));
    }

    public function delete($ins_id){
        $institution = Institution::query()->find($ins_id);
        if(!$institution)
            return redirect()->route('admin.institution')->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);
    }

    public function addTag(Request $request){

        InstitutionTags::query()->where('institution_id', $request->get('institution_id'))->delete();


        if ($request->has('tags')){
            foreach ($request->get('tags') as $tag){
                InstitutionTags::query()->create([
                    'institution_id' => $request->get('institution_id'),
                    'tag_id' => $tag
                ]);
            }
        }

        return back()->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);
    }

}

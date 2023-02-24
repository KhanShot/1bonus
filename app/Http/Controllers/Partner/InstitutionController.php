<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstitutionStoreRequest;
use App\Http\Requests\Admin\InstitutionUpdateRequest;
use App\Http\Traits\Utils;
use App\Models\Categories;
use App\Models\Institution;
use App\Models\InstitutionAddress;
use App\Models\InstitutionPhones;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstitutionController extends Controller
{

    public function index(){
        $institution = Institution::with(['address', 'phones'])->where('user_id', auth()->user()->id)->first();
//        dd($institution);
        $tags = Tags::query()->get();
        $categories = Categories::query()->get();
        return view('partner.institution.index', compact('institution', 'tags', 'categories'));
    }

    public function store(InstitutionStoreRequest $request){
        $data = $request->validated();
        if ($request->hasFile("image")){
            $path = "/assets/institution";
            $request->file("image")->store('public'. $path);
            $name = $request->file("image")->hashName() ;
            $data['image'] = $path."/".$name;
        }
        if ($request->hasFile("logo")){
            $path = "/assets/institution";
            $request->file("logo")->store('public'. $path);
            $name = $request->file("logo")->hashName() ;
            $data['logo'] = $path."/".$name;
        }

        $institutionData = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $data['image'],
            'logo' => $data['logo'],
            'category_id' => $data['category'],
            'insta' => $data['insta'] ?? '',
            'telegram' => $data['telegram'] ?? '',
            'whatsapp' => $data['whatsapp'] ?? '',
            'user_id' => auth()->user()->id,
        );

        $institution = Institution::query()->create($institutionData);

        $institution_address = array(
            'institution_id' => $institution->id,
            'full_address' => $request->get('full_address'),
            'long' => $request->get('long'),
            'lat' => $request->get('lat'),
            'city' => $request->get('city'),
            'street' => $request->get('street'),
            'premiseNumber' => $request->get('premiseNumber'),
        );

        InstitutionAddress::query()->create($institution_address);

        InstitutionPhones::query()->create([
            'institution_id' => $institution->id,
            'phone' => $request->get('phone'),
        ]);

        return back()->with('success', Utils::$MESSAGE_SUCCESS_ADDED);
    }


    public function update(InstitutionUpdateRequest $request, $institution_id)
    {
        $institution = Institution::query()->find($institution_id);
        if (!$institution)
            return back()->with('error', Utils::$MESSAGE_DATA_NOT_FOUND);

        $institution->name = $request->get("name");
        $institution->description = $request->get("description");
        $institution->insta = $request->get("insta");
        $institution->telegram = $request->get("telegram");
        $institution->whatsapp = $request->get("whatsapp");
        $institution->category_id = $request->get("category");

        if ($request->hasFile("image")) {
            Storage::delete("public" . $institution->image);
            $path = "/images/institution";
            $request->file("image")->store('public' . $path);
            $institution->image = $path . "/" . $request->file("image")->hashName();
        }

        if ($request->hasFile("logo")) {
            Storage::delete("public" . $institution->logo);
            $path = "/images/institution";
            $request->file("logo")->store('public' . $path);
            $institution->logo = $path . "/" . $request->file("logo")->hashName();
        }

        $institution->save();
        $address = array(
            'institution_id' => $institution->id,
            'full_address' => $request->get("full_address"),
            'city' => $request->get("city"),
            'street' => $request->get("street"),
            'premiseNumber' => $request->get("premiseNumber"),
            'lat' => $request->get("lat"),
            'long' => $request->get("long")
        );
        InstitutionAddress::query()->update($address);

        InstitutionPhones::query()->where("institution_id", $institution->id)->delete();

        InstitutionPhones::query()->create([
            'phone' => $request->get('phone') ?? '',
            'institution_id' => $institution->id
        ]);

        return back()->with('success', Utils::$MESSAGE_SUCCESS_UPDATED);
    }

}

<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Institution;
use App\Models\Service;
use App\Models\ServiceCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    use TJsonResponse;
    public function index(){
        $services = [];
        $institution = Institution::query()->where('user_id', auth()->user()->id)->first();
        if (!$institution)
            return redirect()->route('partner.institution')->with('success', Utils::$MESSAGE_DATA_NOT_FOUND );

        return view('partner.services.index', compact('institution'));
    }

    public function getList($institution_id){
        return Service::with(['category'])->where('institution_id', $institution_id)->get();
    }

    public function createCategory(Request $request, $institution_id){
        if ($request->get('name'))
            ServiceCategories::query()->create([
            'institution_id' => $institution_id,
            'name' => $request->get('name')]);

        return $this->successResponse(null, ['data' => $request->all()]);
    }

    public function getCategories($institution_id){
        return ServiceCategories::query()->where('institution_id', $institution_id)->get();
    }

    public function store(Request $request, $institution_id){
        $data = array(
            'institution_id' => $institution_id,
            'service_category_id' => $request->get('category'),
            'price' => $request->get('price'),
            'name' => $request->get('name'),
        );


        if ($request->hasFile("image")) {
            $path = "/images/services";
            $request->file("image")->store('public' . $path);
            $data['image'] = $path . "/" . $request->file("image")->hashName();
        }

        Service::query()->create($data);

        return $this->successResponse(null, [$request->all()]);
    }


    public function delete($service_id){
        $service = Service::query()->find($service_id);
        if (!$service)
            return $this->failedResponse(Utils::$MESSAGE_DATA_NOT_FOUND, 404);

        Storage::delete("public" . $service->image);
        $service->delete();
        return $this->successResponse(Utils::$MESSAGE_SUCCESS_DELETED, null);

    }

}

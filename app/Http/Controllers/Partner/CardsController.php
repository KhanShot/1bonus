<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Cards;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CardsController extends Controller
{
    use TJsonResponse;
    public function index(){
        $institution = Institution::query()->where('user_id', auth()->user()->id)->first();
        if (!$institution)
            return redirect()->route('partner.institution');

        $institutionCards = Cards::query()
            ->withTrashed()
            ->where('institution_id', $institution->id)
        ->get()->sortBy('deleted_at')->groupBy('group');

        return view('partner.cards.index', compact('institutionCards', 'institution'));
    }

    public function create(){
        $institution = Institution::query()->where('user_id', auth()->user()->id)->first();
        if (!$institution)
            return redirect()->route('partner.institution');

        return view('partner.cards.create', compact('institution'));
    }

    public function store(Request $request, $institution_id){
        $institution = Institution::query()->find($institution_id);
        if (!$institution)
            return redirect()->route("partner.institution")->with("error", Utils::$MESSAGE_DATA_NOT_FOUND);


        $group = Str::random(5);
        DB::beginTransaction();
        Cards::query()->where('institution_id', $institution->id)->delete();
        foreach ($request->get("cards") as $key => $card){
            Cards::query()->create([
                'institution_id' => $institution_id,
                'bonus_name' => $card['bonus_name'] ?? null,
                'visit' => $card['index'],
                'group' => $group,
            ]);
        }
        DB::commit();


        return $this->successResponse(null, ['cards' => $request->all()]);
    }

    public function delete($group){
        Cards::query()->where("group", $group)->delete();
        return back()->with("success", Utils::$MESSAGE_SUCCESS_DELETED);
    }

    public function forceDelete($group){
        Cards::query()->where("group", $group)->forceDelete();
        return back()->with("success", Utils::$MESSAGE_SUCCESS_DELETED);

    }
}

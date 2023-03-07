<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Cards;
use App\Models\Institution;
use App\Models\Service;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function dashboard(){
        return view('partner.pages.dashboard');
    }

    public function filling(){

        $data = array();
        $d_c = '<li><a class="text-decoration-none text-white" href="'. route("partner.cards") .'" > Карточки посещение </a> </li>';
        $d_s = '<li><a class="text-decoration-none text-white" href="'. route("partner.schedule") .'" > График работы </a> </li>';
        $d_sv = '<li><a class="text-decoration-none text-white" href="'. route("partner.services") .'" > Усулги </a> </li>';
        $institution = Institution::query()
            ->with(['schedule','services_category.services'])
            ->where('user_id', auth()->user()->id)->first();
        if (!$institution){
            $data[] = '<li><a class="text-decoration-none text-white" href="'. route("partner.institution") .'" > Заведение </a> </li>';
            $data[] = $d_c;
            $data[] = $d_s;
            $data[] = $d_sv;
            return $data;
        }

        if (count($institution->schedule) == 0)
            $data[] = $d_s;
        $cards = Cards::query()->where('institution_id', $institution->id)->get();
        if ($cards->count() == 0)
            $data[] = $d_c;

        $services = Service::query()->where('institution_id', $institution->id)->get();

        if ($services->count() == 0)
            $data[] = $d_sv;
        return $data;
    }

}

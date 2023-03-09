<?php

namespace App\Http\Services;

use App\Models\Cards;
use App\Models\Institution;
use App\Models\Service;

class InstitutionService
{
    public function getRequiredFillings($user_id): array
    {
        $data = array();
        $d_c = '<li><a class="text-decoration-none text-white" href="'. route("partner.cards") .'" > Карточки посещение </a> </li>';
        $d_s = '<li><a class="text-decoration-none text-white" href="'. route("partner.schedule") .'" > График работы </a> </li>';
        $d_sv = '<li><a class="text-decoration-none text-white" href="'. route("partner.services") .'" > Усулги </a> </li>';
        $institution = Institution::query()
            ->with(['schedule','services_category.services'])
            ->where('user_id', $user_id)->first();
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

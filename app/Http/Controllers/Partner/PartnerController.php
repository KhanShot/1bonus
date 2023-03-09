<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Services\InstitutionService;
use App\Models\Cards;
use App\Models\Institution;
use App\Models\Service;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function dashboard(){
        return view('partner.pages.dashboard');
    }

    public function filling(InstitutionService $service): array
    {
        return $service->getRequiredFillings(auth()->user()->id);
    }

}

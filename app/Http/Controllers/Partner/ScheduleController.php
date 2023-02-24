<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Traits\TJsonResponse;
use App\Models\Institution;
use App\Models\InstitutionSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    use TJsonResponse;
    public function index(){
        $institution = Institution::query()->where('user_id', auth()->user()->id)->first();
        if (!$institution)
            return redirect()->route('partner.institution');

        return view('partner.schedule.index', compact('institution'));
    }

    public function getSchedule($institution_id){
        $institutionSchedule = InstitutionSchedule::query()->where("institution_id", $institution_id)->get();
        $data = $institutionSchedule->transform(function ($item){
            return [
                $item->day => [
                    'close' => $item->close,
                    'open' => $item->open,
                    'dayoff' => $item->dayOff,
                ]
            ];
        });

        return $this->successResponse(null, ['schedule' => $data]);
    }

    public function store(Request $request, $institution_id){
        InstitutionSchedule::query()->where("institution_id", $institution_id)->delete();

        $data = array(
            [
                'institution_id' => $institution_id,
                'day' => 'mon',
                'dayNumber' => 1,
                'open' => $request->mon['open'],
                'close' => $request->mon['close'],
                'dayoff' => $request->mon['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'tue',
                'dayNumber' => 2,
                'open' => $request->tue['open'],
                'close' => $request->tue['close'],
                'dayoff' => $request->tue['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'wed',
                'dayNumber' => 3,
                'open' => $request->wed['open'],
                'close' => $request->wed['close'],
                'dayoff' => $request->wed['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'thu',
                'dayNumber' => 4,
                'open' => $request->thu['open'],
                'close' => $request->thu['close'],
                'dayoff' => $request->thu['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'fri',
                'dayNumber' => 5,
                'open' => $request->fri['open'],
                'close' => $request->fri['close'],
                'dayoff' => $request->fri['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'sat',
                'dayNumber' => 6,
                'open' => $request->sat['open'],
                'close' => $request->sat['close'],
                'dayoff' => $request->sat['dayoff']
            ],
            [
                'institution_id' => $institution_id,
                'day' => 'sun',
                'dayNumber' => 7,
                'open' => $request->sun['open'],
                'close' => $request->sun['close'],
                'dayoff' => $request->sun['dayoff']
            ],
        );

        InstitutionSchedule::insert($data);

        return $this->successResponse("ok", $data);
    }



}

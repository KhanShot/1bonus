<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstituionDetailResource;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Banner;
use App\Models\Institution;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    use TJsonResponse;
    public function detail($institution_id){
        $institution = Institution::with(['category', 'address', 'phones', 'services_category.services', 'schedule'])
            ->withAvg('rating','point')->find($institution_id);

        if (!$institution)
            return $this->failedResponse(Utils::$MESSAGE_DATA_NOT_FOUND,404);

        $institution['cards_count'] = 0;
        $institution['user_cards'] = 0;
        $institution['favourite_has'] = false; //TODO change this lines

        return $this->successResponse(null,
            $institution
        );
    }


    public function getList(Request $request){

        $institution = Institution::with('schedule')

            ->withAvg('rating','point');


        if ($request->has('category_id')){
            $institution = $institution->where('category_id', $request->get('category_id'));
        }


        if ($request->has('tag_id')){

           $institution = $institution->whereHas('tags', function ($query) use ($request){
                $query->where('tags.id', $request->get('tag_id'));
            });
        }

        $data = array();
        $closed_arr = array();
        foreach ($institution->get() as $inst){

            foreach ($inst->schedule as $schedule){
                if ($schedule->dayNumber == now()->isoFormat('d')){
                    $data[] = $schedule;
                    if ($schedule['dayOff'])
                        $closed_arr[] = $schedule['institution_id'];
                    else{
                        $open = Carbon::createFromTimeString($schedule['open']);
                        $close = Carbon::createFromTimeString($schedule['close']);
                        if (!now()->between($open, $close))
                            $closed_arr[] = $schedule['institution_id'];
                    }
                }
            }
        }

        if ($request->has('schedule')){
            if ($request->get('schedule') == 'open'){
                $institution = $institution->whereNotIn('id', $closed_arr);
            }if ($request->get('schedule') == 'close'){
                $institution = $institution->whereIn('id', $closed_arr);
            }
        }


        if ($request->has('used')){

        }


        return $institution->get()->transform(function ($item) use ($data){

            foreach ($data as $schedule){
                if ($schedule['institution_id'] == $item->id){
                    $item->new_schedule = $schedule;
                    if ($schedule['dayOff'])
                        $item->open = false;
                    else{
                        $open = Carbon::createFromTimeString($schedule['open']);
                        $close = Carbon::createFromTimeString($schedule['close']);
                        $item->open = now()->between($open, $close);
                    }
                }
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'full_address' => $item->address->full_address ?? '',
                'image' => $item->image,
                'avg_rating' => $item->rating_avg_point,
                'schedule' => $item->new_schedule,
                'open' => $item->open,
                ];
        });
    }
}

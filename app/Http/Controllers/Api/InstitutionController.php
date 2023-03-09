<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstituionDetailResource;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Banner;
use App\Models\Cards;
use App\Models\Favourite;
use App\Models\Institution;
use App\Models\InstitutionAddress;
use App\Models\UserCards;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    private string $api_key = '75702eb0-9309-013b-9a8b-0655440f3abc';
    private string $secret_key = '73526dffe2823298be051ed9be8c3e07e011233f3f50c9a9';
    use TJsonResponse;
    public function detail($institution_id){
        $institution = Institution::with(['category', 'address', 'phones', 'services_category.services', 'schedule'])
            ->where('is_filled', 1)
            ->withAvg('rating','point')->find($institution_id);

        if (!$institution)
            return $this->failedResponse(Utils::$MESSAGE_DATA_NOT_FOUND,404);

        $institution['cards_count'] = Cards::query()->where('institution_id', $institution->id)->count();
        $institution['user_cards'] = UserCards::query()
            ->where('is_finished', '=',false)
            ->where('user_id', auth()->user()->id)
            ->where('institution_id', $institution->id)
            ->where('used', 1)
            ->count();

        $fav =  Favourite::query()->where('institution_id', $institution_id)
            ->where('user_id', auth()->user()->id)->first();
//        return $fav;
        $institution['favourite_has'] = (bool)$fav;

        $institution['rating'] = round($institution->rating_avg_point, 2);
        return $this->successResponse(null,
            $institution
        );
    }

    public function getCards($institution_id)
    {
        $wash = Institution::query()
            ->where('is_filled', 1)
            ->find($institution_id);
        if (!$wash)
            return $this->failedResponse("Автомойка не найдена!", 404);

        $userCards = UserCards::query()->select('*', 'service as bonus_name')->where('user_id', auth()->user()->id)
            ->where('institution_id', $institution_id)
            ->where('is_finished', 0)
            ->get();


        $data['has_card'] = sizeof($userCards) > 1;


        if ($data['has_card'])
            $data['card'] = $userCards;
        else{
            $data['card'] = Cards::query()->where('institution_id', $institution_id)->get()->sortBy('visit');
        }

        return $this->successResponse(null, $data);

    }


    public function getList(Request $request){

        $cities = InstitutionAddress::query()->where('city_id', auth()->user()->city_id)->pluck('institution_id');

        $institution = Institution::with(['schedule'])
            ->where('is_filled', 1)
            ->whereIn('id', $cities)
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
                        if (!is_null($schedule['open']) && !is_null($schedule['close'])){
                            $open = Carbon::createFromTimeString($schedule['open']);
                            $close = Carbon::createFromTimeString($schedule['close']);
                            if (!now()->between($open, $close))
                                $closed_arr[] = $schedule['institution_id'];
                        }else{
                            $closed_arr[] = $schedule['institution_id'];
                        }


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
            $inst_list = UserCards::query()->where('user_id', auth()->user()->id)->pluck('institution_id')->unique();
            $institution = $institution->whereIn('id', $inst_list);
        }

        if ($request->has('sort')){
            if ($request->get('sort') == 'rating'){
                $institution = $institution->orderBy('rating_avg_point', 'Desc');
            }
        }

        return $institution->get()->transform(function ($item) use ($data){

            foreach ($data as $schedule){

                    if ($schedule['institution_id'] == $item->id){
                        $item->new_schedule = $schedule;
                        if ($schedule['dayOff'])
                            $item->open = false;
                        else{
                            if (!is_null($schedule['open']) && !is_null($schedule['close'])){
                                $open = Carbon::createFromTimeString($schedule['open']);
                                $close = Carbon::createFromTimeString($schedule['close']);
                                $item->open = now()->between($open, $close);
                            }else{
                                $item->open == false;
                            }
                        }
                    }
            }

            $fav =  Favourite::query()->where('institution_id', $item->id)
                ->where('user_id', auth()->user()->id)->first();

            $fav_has = (bool)$fav;

            return [
                'id' => $item->id,
                'name' => $item->name,
                'full_address' => $item->address->street .' '.$item->address->premiseNumber ?? '',
                'image' => $item->image,
                'rating' => round($item->rating_avg_point, 2),
//                'open' => $item->open,
                'lat' => $item->address->lat ?? null,
                'long' => $item->address->long ?? null,
                'favourite_has' => $fav_has,
//                'new_schedule' => $item->new_schedule,
                'user_cards' => UserCards::query()

                    ->where('is_finished', '=',false)
                    ->where('user_id', auth()->user()->id)
                    ->where('institution_id', $item->id)
                    ->where('used', 1)
                    ->count(),
                'cards_count' => UserCards::query()
                    ->where('is_finished', '=',false)
                    ->where('user_id', auth()->user()->id)
                    ->where('institution_id', $item->id)
                    ->count(),
                ];
        });
    }



    public function getMyInstitutions(){

        $inst_list = UserCards::query()->where('user_id', auth()->user()->id)->pluck('institution_id')->unique();

        $institution = Institution::with('schedule')
            ->where('is_filled', 1)
            ->whereIn('id', $inst_list)
            ->withAvg('rating','point');

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

            $fav =  Favourite::query()->where('institution_id', $item->id)
                ->where('user_id', auth()->user()->id)->first();

            $fav_has = (bool)$fav;
            return [
                'id' => $item->id,
                'name' => $item->name,
                'full_address' => $item->address->street .' '.$item->address->premiseNumber ?? '',
                'image' => $item->image,
                'rating' => round($item->rating_avg_point, 2),
                'open' => $item->open,
                'favourite_has' => $fav_has,

                'user_cards' => UserCards::query()
                    ->where('is_finished', '=',false)
                    ->where('user_id', auth()->user()->id)
                    ->where('institution_id', $item->id)
                    ->where('used', 1)
                    ->count(),
                'cards_count' => UserCards::query()
                    ->where('is_finished', '=',false)
                    ->where('user_id', auth()->user()->id)
                    ->where('institution_id', $item->id)
                    ->count(),
            ];
        });
    }
}

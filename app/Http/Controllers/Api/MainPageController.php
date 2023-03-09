<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Cards;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Favourite;
use App\Models\Institution;
use App\Models\InstitutionAddress;
use App\Models\Tags;
use App\Models\UserCards;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function getBanners(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Banner::query()->get()->sortBy('order');
    }

    public function getCategories(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Categories::query()->get();
    }

    public function getTags(){

        $cities = InstitutionAddress::query()->where('city_id', auth()->user()->city_id)->pluck('institution_id');

        $tags =  Tags::query()->with(['institution.address', 'institution' => function($query) use ($cities){
            $query->withAvg('rating', 'point');
            $query->where('is_filled', 1);
            $query->whereIn('institution_id', $cities);
        }])
            ->get();

//        return $tags;

        return $tags->transform(function ($item){
            $newItem = array();
            $newItem['id'] = $item->id;
            $newItem['name'] = $item->name;
            $newItem['image'] = $item->image;
            $newItem['order'] = $item->order;
            $fav =  Favourite::query()->where('institution_id', $item->id)
                ->where('user_id', auth()->user()->id)->first();

            $fav_has = (bool)$fav;

            $newInst = array();
            foreach ($item->institution as $institution){
                $inst = array();
                $inst['id'] = $institution->id;
                $inst['name'] = $institution->name;
                $inst['image'] = $institution->image;
                $inst['full_address'] = $institution->address->street .' '.$institution->address->premiseNumber ?? '';
                $inst['cards_count'] = Cards::query()->where('institution_id', $institution->id)->count();
                $inst['user_cards'] = UserCards::query()
                    ->where('is_finished', '=',false)
                    ->where('user_id', auth()->user()->id)
                    ->where('institution_id', $institution->id)
                    ->where('used', 1)
                    ->count();
                $inst['favourite_has'] = $fav_has;
                $inst['rating'] = round($institution->rating_avg_point,2);
                foreach ($institution->schedule as $schedule){
                    if ($schedule->dayNumber == now()->isoFormat('d')){
//                        $inst['schedule'] = $schedule;

                        if ($schedule['dayOff'])
                            $inst['open'] = false;
                        else{
                            $inst['open'] = true;
                            $open = Carbon::createFromTimeString($schedule['open']);
                            $close = Carbon::createFromTimeString($schedule['close']);
                            if (!now()->between($open, $close))
                                $inst['open'] = false;
                        }
                    }
                }
                $newInst[] = $inst;
            }

            $newItem['institution'] = $newInst;
            return $newItem;
        });

    }

    public function getCities(){
        return Cities::query()->get();
    }
}

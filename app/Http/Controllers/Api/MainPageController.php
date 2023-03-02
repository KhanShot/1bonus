<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Institution;
use App\Models\Tags;
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
        $tags =  Tags::query()->with(['institution.address', 'institution' => function($query){
            $query->withAvg('rating', 'point');
        }])
            ->get();




        return $tags->transform(function ($item){
            $newItem = array();

            $newItem['id'] = $item->id;
            $newItem['name'] = $item->name;
            $newItem['image'] = $item->image;
            $newItem['order'] = $item->order;


            $newInst = array();
            foreach ($item->institution as $institution){
                $inst = array();
                $inst['id'] = $institution->id;
                $inst['name'] = $institution->name;
                $inst['image'] = $institution->image;
                $inst['full_address'] = $institution->address->street .' '.$institution->address->premiseNumber ?? '';
                $inst['cards_count'] = 0;
                $inst['user_cards'] = 0; //TODO change here
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use App\Models\Favourite;
use App\Models\Institution;
use App\Models\UserCards;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use TJsonResponse;
    public function subscribe(Request $request, $institution_id){
        $institution = Institution::query()->find($institution_id);
        if (!$institution)
            return $this->failedResponse(Utils::$MESSAGE_DATA_NOT_FOUND, 404);

        $fav = Favourite::query()->where('user_id', auth()->user()->id)
            ->where('institution_id', $institution_id)
            ->first();

        if ($fav)
            return $this->failedResponse("Заведение уже находится в списке избранных!", 400);

        Favourite::query()->create(['user_id' => auth()->user()->id, 'institution_id' => $institution_id]);

        return $this->successResponse("Заведение добавлена в список избранных!");
    }


    public function unsubscribe(Request $request, $institution_id){
        $institution = Institution::query()->find($institution_id);
        if (!$institution)
            return $this->failedResponse(Utils::$MESSAGE_DATA_NOT_FOUND, 404);

        $fav = Favourite::query()->where('user_id', auth()->user()->id)
            ->where('institution_id', $institution_id)
            ->first();
        if (!$fav)
            return $this->failedResponse("Заведение не существует в списке избранных!", 400);

        $fav->delete();
        return $this->successResponse("Заведение удалена из список избранных!");
    }

    public function getList(Request $request){
        $favList = Favourite::query()->where('user_id', auth()->user()->id)->pluck('institution_id');
        $institution = Institution::with('schedule')
            ->whereIn('id', $favList)
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

            return [
                'id' => $item->id,
                'name' => $item->name,
                'full_address' => $item->address->street .' '.$item->address->premiseNumber ?? '',
                'image' => $item->image,
                'rating' => round($item->rating_avg_point, 2),
                'open' => $item->open,
                'favourite_has' => true,
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

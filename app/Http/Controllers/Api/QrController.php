<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QrAttendanceRequest;
use App\Http\Traits\Helper;
use App\Http\Traits\TJsonResponse;
use App\Models\Cards;
use App\Models\Institution;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrController extends Controller
{
    use TJsonResponse;
    use Helper;
    public function attendance(QrAttendanceRequest $request){
        $institution = Institution::query()->where('user_id', auth()->user()->id)->first();
//        dd(User::with('fcm')->find($request->get('user_id'))->fcm->token);
        if (!$institution)
            return $this->failedResponse('Добавьте заведение',400,null,'institution_required');

        $userCards = UserCards::query()->where('user_id', $request->get('user_id'))
            ->where('institution_id', $institution->id)->where('is_finished', 0);

//        return sizeof($userCards->get());

        if (sizeof($userCards->get()) == 0){ //if user has no cards
            $cards = Cards::query()->where('institution_id', $institution->id)->get();

            if ($cards->count() == 0)
                return $this->failedResponse('В автомойке нет карточки',404, null,'card_required');

            DB::beginTransaction();
            foreach ($cards as $card){
                UserCards::query()->create([
                    'visit' => $card->visit,
                    'group' => $card->group,
                    'institution_id' => $card->institution_id,
                    'user_id' => $request->user_id,
                    'time_used' => $card->visit == 1 ? now() : null,
                    'used' => $card->visit == 1 ? 1 : 0,
                    'service' => $card->bonus_name ?? null
                ]);
            }
            DB::commit();

//            return 'first';
        }else{ // if user has cards
            $current_visit = null;
            foreach ($userCards->get()->sortBy('visit') as $card ){
                if (!$card->used && is_null($card->time_used)){
                    $current_visit = $card;
                    break;
                }
            }

            if ($current_visit != null){
                $current_visit->update([
                    'used' => 1,
                    'time_used' => now(),
                ]);
            }else{
                $userCards->update(['is_finished' => 1]);
                $cards = Cards::query()->where('institution_id', $institution->id)->get();
                DB::beginTransaction();
                foreach ($cards as $card){
                    UserCards::query()->create([
                        'visit' => $card->visit,
                        'group' => $card->group,
                        'institution_id' => $card->institution_id,
                        'user_id' => $request->user_id,
                        'time_used' => $card->visit == 1 ? now() : null,
                        'used' => $card->visit == 1 ? 1 : 0,
                        'service' => $card->bonus_name ?? null
                    ]);
                }
                DB::commit();


            }

//            return 'second';
        }
        //TODO push notification
        $data['header'] = 'Оцените заведение!';
        $data['text'] = "Понравилось ли вам это заведение?";
        $data['fcm_tokens'] = [User::with('fcm')->find($request->get('user_id'))->fcm->token];
        $data['data'] = array(
            'institution_id' => $institution->id,
            'user_id' => $request->get('user_id')
        );
        return $this->successResponse("qr postavlen uspewno!");
    }
}

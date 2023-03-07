<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PastRatingRequest;
use App\Http\Traits\TJsonResponse;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    use TJsonResponse;
    public function past(PastRatingRequest $request){
        Rating::query()->create([
            'user_id' => auth()->user()->id,
            'institution_id' => $request->get('institution_id'),
            'point' => $request->get('point'),
        ]);
        return $this->successResponse('Рейтинг поставлен успещно!');
    }

}

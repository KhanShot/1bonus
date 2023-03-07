<?php

namespace App\Http\Traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Illuminate\Http\JsonResponse;

trait TJsonResponse
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success'=> false, "message" => "validation Error" ,'errors' => $validator->errors(), 'error_code' => null],
            422, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));
    }


    public function successResponse($message, $data=null): JsonResponse
    {
        throw new HttpResponseException(response()->json(['success'=> true, 'message'=> $message, 'data' => $data ],
            200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));
    }

    public function failedResponse($message, $status, $data=null, $error_code=null){
        throw new HttpResponseException(response()->json(['success'=> false, 'message'=> $message, "errors" => $data, 'error_code' => $error_code ],
            $status, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));
    }

    public function sendNotification($dota)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = $dota['fcm_tokens'];

        $serverKey = 'AAAAunBiSlI:APA91bFJsQZnKouiHwWT694VoHkYTL2qHjK6c2ihA4ROwHIwZX17v_qJk1B6N1V3yevp5_rJzUimFCsv9XgaNuet_w4zoLSLCgkU_78zTRjMcHh9yWYiu2skV1se3Zk18HgUti-CAg72'; // ADD SERVER KEY HERE PROVIDED BY FCM

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $dota['header'],
                "body" => $dota['text'],
            ],
            'data' => $dota['data'],
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return $result;
    }
}

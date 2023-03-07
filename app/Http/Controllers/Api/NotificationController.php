<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;
use App\Http\Traits\TJsonResponse;
use App\Http\Traits\Utils;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use TJsonResponse;

    public function getList(NotificationService $service){
        $data = $service->getList();
        return $this->successResponse(null, $data);
    }

    public function readAll(NotificationService $service){
        $service->readAll();
        return $this->successResponse(Utils::$MESSAGE_SUCCESS_POST);
    }

    public function unread(NotificationService $service){
        $data = $service->getUnread();
        return $this->successResponse(null, $data);
    }
}

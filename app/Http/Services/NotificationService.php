<?php

namespace App\Http\Services;

use App\Http\Traits\Helper;

class NotificationService
{
    use Helper;
    public function getList(){
        $data = auth()->user()->notifications;
//        return $data;
        return $data->transform(function ($item){
            return [
                'id' => $item->id,
                'header' => $item->data['header'],
                'body' => $item->data['text'],
                'date' => $this->getCreatedAtAttribute($item->created_at),
//                'type' => $item->data['type'] ?? '',
//                'type_id' => $item->data['type_id'] ?? '',
                'read_at' => $item->read_at
            ];
        });
    }

    public function readAll(){
        auth()->user()->notifications->markAsRead();

    }

    public function getUnread(){
        return [
            'all' => auth()->user()->notifications->count(),
            'unread' => auth()->user()->unreadNotifications->count(),
        ];
    }
}

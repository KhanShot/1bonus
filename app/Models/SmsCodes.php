<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCodes extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'phone', 'user_id','service_sms_id',
        'type', 'status','reason', 'verified', 'password'
    ];
}

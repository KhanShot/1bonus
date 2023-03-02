<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFcmToken extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'token', 'user_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit', 'used', 'time_used', 'service',
        'institution_id', 'user_id', 'group', 'is_finished',
    ];
}

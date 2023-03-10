<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cards extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id', 'bonus_name', 'visit', 'group',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionAddress extends Model
{

    use HasFactory; // TODO change syntax
    protected $fillable = [
        'institution_id', 'lat', 'long', 'city',
        'full_address', 'premiseNumber', 'street',
    ];

    public $timestamps = false;

}

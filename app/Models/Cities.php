<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'lat', 'long', 'zoomLevel',
    ];

    public function institution(){
        return $this->hasManyThrough(Institution::class, InstitutionAddress::class,'city_id', 'id');
    }

    public function user(){
        return $this->hasMany(User::class, 'city_id');
    }
}

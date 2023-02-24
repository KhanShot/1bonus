<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'order', 'image',
    ];

    public function institution(){
        return $this->hasManyThrough(Institution::class, InstitutionTags::class,'institution_id', 'id','id','tag_id');
    }
}

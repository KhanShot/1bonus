<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'institution_id', 'price',
        'image', 'service_category_id',
    ];


    public function category(){
        return $this->belongsTo(ServiceCategories::class, 'service_category_id');
    }

}

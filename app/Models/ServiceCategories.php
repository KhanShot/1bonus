<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategories extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'institution_id'
    ];

    public function services(){
        return $this->hasMany(Service::class, 'service_category_id');
    }
}

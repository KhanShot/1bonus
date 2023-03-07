<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'description',
        'insta', 'telegram', 'whatsapp', 'logo', 'image',
        'bg_image',
    ];
    public function phones(){
        return $this->hasOne(InstitutionPhones::class, 'institution_id');
    }
    public function address(){
        return $this->hasOne(InstitutionAddress::class, 'institution_id');
    }

    public function userCity()
    {
        return $this->address()->where('city_id', auth()->user()->city_id)->pluck('institution_id');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function services_category(){
        return $this->hasMany(ServiceCategories::class,'institution_id');
    }

    public function schedule(){
        return $this->hasMany(InstitutionSchedule::class, 'institution_id');
    }

    public function rating(){
        return $this->hasMany(Rating::class, 'institution_id');
    }

    public function tags(){
        return $this->belongsToMany(Tags::class,'institution_tags', 'institution_id', 'tag_id');
    }


}

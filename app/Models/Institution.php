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
        return $this->hasMany(InstitutionPhones::class, 'institution_id');
    }
    public function address(){
        return $this->hasOne(InstitutionAddress::class, 'institution_id');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Categories::class, 'category_id');
    }
}

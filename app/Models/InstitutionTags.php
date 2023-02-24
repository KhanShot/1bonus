<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionTags extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id', 'tag_id',
    ];

    public $timestamps = false;

}

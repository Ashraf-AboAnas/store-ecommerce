<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable; // trait with packege translatable
    protected $with = ['translations'];
    protected $fillable = ['parent_id', 'slug', 'is_active'];

    protected $translatedAttributes = ['name'];
    protected $Hidden = ['tranlations'];
    protected $casts=[
        'is_active' => 'boolean'

    ];
}

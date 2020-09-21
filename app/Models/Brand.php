<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable; // trait with packege translatable
    protected $with = ['translations'];
    protected $fillable = ['is_active','photo'];
    protected $translatedAttributes = ['name'];
    protected $hidden = ['tranlations'];
    protected $casts = [
        'is_active' => 'boolean',

    ];
    public function getactive()
    {
        return $this->is_active == 1 ? 'غير مفعل' : 'مفعل';

    }

    public function getPhotoAttribute($value)
    {
       return ($value !== null) ? asset('assets/images/brands/'.$value):"";
    }
}

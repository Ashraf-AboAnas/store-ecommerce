<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable; // trait with packege translatable
    protected $with = ['translations'];
    protected $fillable = ['slug'];
    protected $hidden = ['tranlations'];
    protected $translatedAttributes = ['name'];

    // public function getCreatedAtAttribute()
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('Y-m-d H:i:s');
    // }

    // public function getUpdatedAtAttribute()
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('Y-m-d H:i:s');
    // }

}

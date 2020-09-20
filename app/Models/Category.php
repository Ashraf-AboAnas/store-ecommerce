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
    protected $hidden = ['tranlations'];
    protected $casts = [
        'is_active' => 'boolean',

    ];
    public function scopeParent($q)
    {

        return $q->whereNull('parent_id');
    }
    public function getactive()
    {
        return $this->is_active == 1 ? 'غير مفعل' : 'مفعل';

    }
    /*************sub category********************* */
    public function scopeChild($q)
    {

        return $q->whereNotNull('parent_id');
    }
    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

}

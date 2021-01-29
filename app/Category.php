<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    //protected $fillable = ['name',];
    protected $guarded = [];
    public $translatedAttributes = ['name'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}

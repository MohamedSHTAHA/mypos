<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    
    use \Dimsav\Translatable\Translatable;

    //protected $fillable = ['name','description'];
    protected $guarded = [];
    public $translatedAttributes = ['name','description'];

    protected $appends = ['image_path','profit_percent'];



    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function getImagePathAttribute()
    {
        return asset('uploads/product_images/'.$this->image);
    }//end of image path attribute

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return number_format($profit_percent, 2);

    }//end of get profit attribute

    public function orders()
    {
        return $this->belongsToMany(Order::class,'product_order');
    }
}

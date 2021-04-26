<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    //protected $fillable = ['name'];
    public $translatedAttributes = ['name'];
    protected $guarded= [];

    public function products (){
        return $this->hasMany(Product::class);
    }
}//end of model

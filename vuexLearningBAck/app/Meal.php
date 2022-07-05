<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    //

    public function getImageAttribute($value){
        if($value){
            return asset('images/meal/'. $value);
        }
    }
}

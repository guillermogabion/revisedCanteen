<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ScheduledDish;
class Meal extends Model
{
    //

    public function getImageAttribute($value){
        if($value){
            return asset('images/meal/'. $value);
        }
    }

    public function dishes(){
        return $this->belongsTo(ScheduledDish::class);
    }
}

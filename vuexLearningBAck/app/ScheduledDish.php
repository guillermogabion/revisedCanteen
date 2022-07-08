<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledDish extends Model
{
    //

    public function dishesToday(){
        return $this->belongsto(Meal::class);
    }
}

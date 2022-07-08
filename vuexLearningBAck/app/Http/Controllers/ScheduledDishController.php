<?php

namespace App\Http\Controllers;
use App\ScheduledDish;
use App\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\ScheduledDishResource;
use Carbon\Carbon;

class ScheduledDishController extends Controller
{
    //

    public function scheduledDish(){
        $dish = ScheduledDish::whereDate('date', Carbon::today())->get();
        return ScheduledDishResource::collection($dish);
        // return $dish->name;

        // $dish = ScheduledDish::with('dishesToday')->get();
        // return $dish;
        
    }
    public function addDishSchedule(Request $request){
        $dish = new ScheduledDish;
        $dish->dish_id = $request->id;
        $dish->date = $request->date;
        $dish->price = $request->price;
        $dish->save();
        return $dish;
    }

    public function updateScheduledDish(Request $request, $id){
        $dish = ScheduledDish::findorfail($id);
        $dish->date = $request->date;
        $dish->price = $request->price;
        $dish->save();
        return $dish;
    }

    public function deleteScheduledDish($id){
        $dish = ScheduledDish::findorfail($id);
        $dish->delete();
        return "Success Delete";
    }
}

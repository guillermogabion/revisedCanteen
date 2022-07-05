<?php

namespace App\Http\Controllers;
use App\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    //

    public function addMeal(Request $request){
        $meal = New Meal;
        $meal->name = $request->name;
        $meal->description = $request->description;
        if($request->image){
            $image = $request->image;  // your base64 encoded
            list($type, $image) = explode(';', $image);
            list(, $image)      = explode(',', $image);
            $data = base64_decode($image);
            $imageName = date("YmdHis"). '.' . 'jpeg';
            file_put_contents(public_path() . '/' . 'images/meal/' . $imageName, $data);
            $meal->image = $imageName ;
        }

      

        $meal->save();
        return $meal;
    }

    public function updateMeal(Request $request, $id) {
        $meal = Meal::find($id);
        $meal->name = $request->name;
        $meal->description = $request->description;
        if($request->image){
            $image = $request->image;
            list($type, $image) = explode(';', $image);
            list(, $image) = explode(',', $image);
            $data = base64_decode($image);
            $imageName = date("YmdHis"). '.'.jpeg;
            file_put_contents(public_path() . '/' . 'images/meal/' . $imageName, $data);
            $meal->image = $imageName ;
        } 
        $meal->save();
        return $meal;
    }

    public function removeMeal($id){
        $meal = Meal::find($id);
        $meal->destroy();
        return "Deleted";
    }

    public function pagination(Request $request){
        $users = Meal::query();
     
        if($request->input('keyword') != ""){
            $keyword = $request->input('keyword');
            $users->where(function($query) use($keyword){
                $query   ->where('name', 'LIKE', "%$keyword%");
                      
            });
        }
        return $users->orderBy('created_at', 'desc')->paginate(10);
    }
    public function searchMeal(Request $request) 
    {
        $user = Meal::query();
        if ($request->input('searchkey') != "") {
            $keyword = $request->input('searchkey');
            $user->where(function($query) use($keyword) {
                $query  ->where('name', 'LIKE', "%$keyword%");
                         
            });
        }
        return $user->orderBy('created_at', 'asc')->get();
    }

    public function getAllmeal(){
        return Meal::get();
    }
}

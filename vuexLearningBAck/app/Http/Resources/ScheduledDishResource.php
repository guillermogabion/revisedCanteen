<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Meal;
class ScheduledDishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dish = Meal::where( 'id', $this->dish_id)->get();
        return [
            'id' => $this->id,
            'dish_id' => $this->dish_id,
            'dish' => $dish,
            'price' => $this->price,
            'date' => $this->date,
        ];
    }
}

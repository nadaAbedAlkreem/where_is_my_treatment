<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
           return
            [
                'id' => $this->id ,
                'name_pharmacy'=> $this->name_pharmacy ,
                'phone_number_pharmacy'=> $this->phone_number_pharmacy ,
                'image_pharmacy'=>  config('app.url').'/'.$this->image_pharmacy ,
                'description' =>$this->description,
                'address'=> new LocationWithOutUserResource($this->location),
                'is_favorite' => $this->is_favorite,
                'average_rating' => $this->ratings->avg('rating'),
                'rating' => $this->ratings,
                'count_rating' => $this->ratings_count,
                'distance' => 'كيلو'. ' ' . round($this->distance, 2)  ,



            ] ;
    }
}

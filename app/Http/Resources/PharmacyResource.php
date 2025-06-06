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
                'image_pharmacy'=> $this->image_pharmacy ,
                'address'=> new LocationWithOutUserResource($this->location),
                'is_favorite' => $this->is_favorite,

            ] ;
    }
}

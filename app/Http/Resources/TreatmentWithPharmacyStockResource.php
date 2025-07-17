<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentWithPharmacyStockResource extends JsonResource
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
                'image' =>  config('app.url').'/'.$this->image ?? '',
                'name' => $this->name,
                'category' => new CategoryResource($this->category),
                'description' => $this->description,
                'about_the_medicine' =>$this->about_the_medicine,
                'how_to_use' =>$this->how_to_use,
                'instructions' =>$this->instructions,
                'side_effects' =>$this->side_effects,
                'is_favorite' =>$this->is_favorite,
                'pharmacy_count_available' => $this->pharmacy_stocks_count ,
                'pharmacy_stock' =>  PharmacyStockResource::collection($this->pharmacyStocks)
              ] ;
    }
}

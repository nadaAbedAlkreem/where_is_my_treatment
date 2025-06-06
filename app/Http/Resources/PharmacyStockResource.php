<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyStockResource extends JsonResource
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
                'price'=> $this->price ,
                'discount_rate'=> $this->discount_rate ,
                'price_after_discount'=>$this->price_after_discount  ,
                'status' => $this->status,
                'quantity' => $this->quantity,
                'expiration_date' => $this->expiration_date,

            ] ;
    }
}

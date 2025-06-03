<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'locationable_id',
        'locationable_type',
        'latitude' ,
        'latitude' ,
        'formatted_address' ,
        'country',
        'city',
        'district',
        'postal_code',
        'location_type',
        'created_at'
    ];

    public function locationable()
    {
        return $this->morphTo();
    }

}

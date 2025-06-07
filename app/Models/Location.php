<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'id',
        'locationable_id',
        'locationable_type',
        'latitude' ,
        'longitude' ,
        'formatted_address' ,
        'country',
        'region',
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

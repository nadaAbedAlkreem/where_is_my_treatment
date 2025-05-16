<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    /** @use HasFactory<\Database\Factories\TreatmentFactory> */
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function pharmacyStocks()
    {
        return $this->hasMany(PharmacyStock::class);
    }

    public function requestTreatments()
    {
        return $this->hasMany(RequestTreatment::class);
    }

}

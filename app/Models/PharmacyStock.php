<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyStock extends Model
{
    /** @use HasFactory<\Database\Factories\PharmacyStockFactory> */
    use HasFactory;


    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

}

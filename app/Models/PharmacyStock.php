<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpseclib3\Crypt\EC\Formats\Keys\Common;

class PharmacyStock extends Model
{
    /** @use HasFactory<\Database\Factories\PharmacyStockFactory> */
    use HasFactory ,softDeletes;
    protected $fillable = [
        'pharmacy_id',
        'treatment_id',
        'price',
        'discount_rate' ,
        'price_after_discount' ,
        'status',
        'quantity' ,
        'is_expired',
        'expiration_date',
        'created_at'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    /** @use HasFactory<\Database\Factories\TreatmentFactory> */
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'category_id' ,
        'name',
        'description',
        'about_the_medicine' ,
        'how_to_use' ,
        'instructions'  ,
        'side_effects' ,
        'image',
        'status_approved'
    ];

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

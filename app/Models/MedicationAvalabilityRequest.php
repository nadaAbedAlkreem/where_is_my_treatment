<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationAvalabilityRequest extends Model
{
    /** @use HasFactory<\Database\Factories\MedicationAvalabilityRequestFactory> */
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function requestTreatments()
    {
        return $this->hasMany(RequestTreatment::class, 'request_id');
    }

}

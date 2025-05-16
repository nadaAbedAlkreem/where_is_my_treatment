<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTreatment extends Model
{
    /** @use HasFactory<\Database\Factories\RequestTreatmentFactory> */
    use HasFactory;

    public function request()
    {
        return $this->belongsTo(MedicationAvailabilityRequest::class, 'request_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

}

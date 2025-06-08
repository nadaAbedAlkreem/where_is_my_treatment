<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use mysql_xdevapi\Table;

class MedicationAvalabilityRequest extends Model
{
    /** @use HasFactory<\Database\Factories\MedicationAvalabilityRequestFactory> */
    use HasFactory , softDeletes;
   protected $fillable = [
     'user_id',
     'treatment_id',
     'pharmacy_id',
     'status'
   ];
   protected $table = "medication_availability_requests";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
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

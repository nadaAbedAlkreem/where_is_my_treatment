<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    /** @use HasFactory<\Database\Factories\PharmaciesFactory> */
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'name_pharmacy',
        'image_pharmacy',
        'license_number' ,
        'license_file_path' ,
        'Expired' ,
        'license_expiry_date' ,
        'phone_number_pharmacy',
        'email_pharmacy',
        'status_exist',
        'status_approved',
        'description',
        'working_hours',
        'created_at'
    ];

    public function administrator()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }

    public function stocks()
    {
        return $this->hasMany(PharmacyStock::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function availabilityRequests()
    {
        return $this->hasMany(MedicationAvalabilityRequest::class);
    }

    public function scopeNotExpireTreatment(Builder $query): Builder
    {
        return $query->where('Expired', false);
    }


}

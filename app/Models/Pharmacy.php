<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    /** @use HasFactory<\Database\Factories\PharmacyFactory> */
    use HasFactory , softDeletes;

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
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pharmacy) {

            $pharmacy->employees()->each(function ($stocks) {
                $stocks->delete();
            });
        });
    }
    public function administrator()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status_exist', 'open');
    }
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status_approved', 'open');
    }

    public function stocks()
    {
        return $this->hasMany(PharmacyStock::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class)->where('type', 'pharmacy');
    }

    public function availabilityTreatmentRequests()
    {
        return $this->hasMany(MedicationAvalabilityRequest::class);
    }

    public function scopeNotExpireTreatment(Builder $query): Builder
    {
        return $query->where('Expired', false);
    }


}

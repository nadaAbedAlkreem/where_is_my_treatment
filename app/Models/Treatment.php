<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    protected $dates = ['deleted_at'];

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status_approved', 'approved');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function searchTreatments()
    {
        return $this->hasMany(TreatmentSearch::class);
    }
    public function medicinesAvaliableRequest()
    {
        return $this->hasMany(MedicationAvalabilityRequest::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($treatment) {

            $treatment->pharmacyStocks()->each(function ($pharmacyStocks) {
                $pharmacyStocks->delete();
            });
            $treatment->searchTreatments()->each(function ($searchTreatment) {
                $searchTreatment->delete();
            });
        });
    }

    public function pharmacyStocks()
    {
        return $this->hasMany(PharmacyStock::class);
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }


    public function requestTreatments()
    {
        return $this->hasMany(RequestTreatment::class);
    }

}

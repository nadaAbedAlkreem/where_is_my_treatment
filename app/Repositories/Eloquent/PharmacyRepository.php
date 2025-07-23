<?php

namespace App\Repositories\Eloquent;

use App\Models\Pharmacy;
use App\Repositories\IPharmacyRepositories;
use App\Traits\ResponseTrait;


class PharmacyRepository  extends BaseRepository implements IPharmacyRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Pharmacy();
    }

    public function getNearestPharmacies($userLat, $userLng)
    {
        return Pharmacy::scopes('Open')->selectRaw("pharmacies.*, locations.latitude, locations.longitude, (
            6371 * acos(
                cos(radians(?)) * cos(radians(locations.latitude)) *
                cos(radians(locations.longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(locations.latitude))
            )
        ) AS distance", [$userLat, $userLng, $userLat])
            ->join('locations', function ($join) {
                $join->on('pharmacies.id', '=', 'locations.locationable_id')
                    ->where('locations.locationable_type', '=', Pharmacy::class);
            })
            ->whereHas('administrator', function ($query) {
                $query->where('status_approved_for_pharmacy', 'approved');
            })
            ->with(['location' , 'administrator','stocks.treatment'])
            ->withExists(['favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
             }])
            ->with(['ratings' => function ($query) {
                $query->whereNotNull('comment')
                    ->with('user');
            }])
             ->withCount('ratings')
             ->withAvg('ratings' ,'rating')
             ->orderBy('distance')
             ->limit(6)
             ->get();
    }

    public function getSearchTreatmentNearestPharmacies($userLat, $userLng, $searchTreatment)
    {
        return Pharmacy::scopes('Open')
            ->selectRaw("pharmacies.*, locations.latitude, locations.longitude, (
              6371 * acos(
                cos(radians(?)) * cos(radians(locations.latitude)) *
                cos(radians(locations.longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(locations.latitude))
            )
        ) AS distance", [$userLat, $userLng, $userLat])
            ->join('locations', function ($join) {
                $join->on('pharmacies.id', '=', 'locations.locationable_id')
                    ->where('locations.locationable_type', '=', Pharmacy::class);
            })
            ->whereHas('administrator', function ($query) {
                $query->where('status_approved_for_pharmacy', 'approved');
            })
            ->whereHas('stocks.treatment', function ($query) use ($searchTreatment) {
                $query->where('name', 'like', '%' . $searchTreatment . '%');
            })
            ->with(['location', 'administrator', 'stocks.treatment'  ])
            ->withExists(['favorites as is_favorite' => function ($q) {
                $q->where('user_id', auth()->id());
            }])
            ->with(['ratings' => function ($query) {
                $query->whereNotNull('comment')
                    ->with('user');
            }])
            ->withCount('ratings')
            ->withAvg('ratings' ,'rating')
            ->orderBy('distance')
            ->limit(6)
            ->get();
    }


}

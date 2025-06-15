<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Treatment;
use App\Repositories\IAdminRepositories;
use App\Repositories\ITreatmentRepositories;
use App\Traits\ResponseTrait;


class TreatmentRepository  extends BaseRepository implements ITreatmentRepositories
{
    use ResponseTrait ;
    public function __construct()
    {
        $this->model = new Treatment();
    }


    public function getApprovedTreatments()
    {
        return $this->model::scopes('Approved');
    }
    public function treatmentAvailabilityPharmacy($pharmacyId , $treatmentsValue)
    {
       $treatments = Treatment::with([
            'pharmacyStocks' => function ($query) use ($pharmacyId) {
                $query->where('pharmacy_id', $pharmacyId)
                    ->where('status', 'available');
            }
        ])
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->whereHas('pharmacyStocks', function ($query) use ($pharmacyId) {
                $query->where('pharmacy_id', $pharmacyId)
                    ->where('status', 'available');
            })
            ->where(function ($q) use ($treatmentsValue) {
                $q->where('name', 'like', "%$treatmentsValue%")
                    ->orWhere('description', 'like', "%$treatmentsValue%");
            })
            ->orderBy('id', 'DESC')
            ->get();

        return $treatments;
     }


}

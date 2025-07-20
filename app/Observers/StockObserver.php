<?php

namespace App\Observers;

use App\Models\MedicationAvalabilityRequest;
use App\Models\PharmacyStock;
use App\Services\api\FcmNotificationService;

class StockObserver
{

    protected   $fcmNotificationService  ;
    public function __construct( FcmNotificationService $fcmNotificationService)
    {
          $this->fcmNotificationService = $fcmNotificationService;
    }
    /**
     * Handle the PharmacyStock "created" event.
     */
    public function created(PharmacyStock $stock): void
    {
        $treatmentId = $stock->treatment_id;
        $pharmacyId = $stock->pharmacy_id;

         $requests = MedicationAvalabilityRequest::where('treatment_id', $treatmentId)
            ->where(function ($q) use ($pharmacyId) {
                $q->whereNull('pharmacy_id')
                ->orWhere('pharmacy_id', $pharmacyId);
            })
             ->with(['treatment' , 'user' ,'pharmacy'])
            ->where('status', 'unavailable')
            ->get();

        foreach ($requests as $request) {
            $title = "لقد تم توفير علاجك ";
            $body = "لقد تم توفير علاج {$request->medicine_name} في صيدلية {$request->pharmacy->name_pharmacy}، يرجى التوجه إلى الصيدلية لاستلامه.";
            $this->fcmNotificationService->sendNotification($title, $body,$request->user_id );

            $request->delete();
        }
    }

    /**
     * Handle the PharmacyStock "updated" event.
     */
    public function updated(PharmacyStock $PharmacyStock): void
    {
        //
    }

    /**
     * Handle the PharmacyStock "deleted" event.
     */
    public function deleted(PharmacyStock $PharmacyStock): void
    {
        //
    }

    /**
     * Handle the PharmacyStock "restored" event.
     */
    public function restored(PharmacyStock $PharmacyStock): void
    {
        //
    }

    /**
     * Handle the PharmacyStock "force deleted" event.
     */
    public function forceDeleted(PharmacyStock $stock): void
    {
        //
    }
}

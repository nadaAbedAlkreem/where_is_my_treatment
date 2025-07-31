<?php

namespace App\Console\Commands;

use App\Models\PharmacyStock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckExpiredPharmacyStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pharmacy:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired treatments and update is_expired field.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        PharmacyStock::whereDate('expiration_date', '<=', $today)
            ->where('is_expired', false)
            ->update(['is_expired' => true]);

        $this->info('Expired treatments updated successfully.');
    }
}

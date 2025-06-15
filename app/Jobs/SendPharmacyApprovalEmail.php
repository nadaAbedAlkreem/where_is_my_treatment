<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PharamcyOwnerJoin;
class SendPharmacyApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    protected $link;

    public function __construct($email, $password, $link)
    {
        $this->email = $email;
        $this->password = $password;
        $this->link = $link;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new PharamcyOwnerJoin($this->email, $this->password, $this->link));
    }

    public function failed(\Throwable $exception)
    {
         Log::error("فشل إرسال البريد إلى: {$this->email} بسبب: {$exception->getMessage()}");
    }


}

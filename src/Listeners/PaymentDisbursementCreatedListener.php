<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\PaymentDisbursement;
use Hasob\FoundationCore\Models\PaymentDisbursementCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentDisbursementCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentDisbursementCreated  $event
     * @return void
     */
    public function handle(PaymentDisbursementCreated $event)
    {
        //
    }
}

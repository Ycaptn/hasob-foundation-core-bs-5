<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\PaymentDisbursement;
use Hasob\FoundationCore\Models\PaymentDisbursementUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentDisbursementUpdatedListener
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
     * @param  PaymentDisbursementUpdated  $event
     * @return void
     */
    public function handle(PaymentDisbursementUpdated $event)
    {
        //
    }
}

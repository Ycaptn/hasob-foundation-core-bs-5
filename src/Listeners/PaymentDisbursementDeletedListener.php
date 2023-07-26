<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\PaymentDisbursement;
use Hasob\FoundationCore\Models\PaymentDisbursementDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentDisbursementDeletedListener
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
     * @param  PaymentDisbursementDeleted  $event
     * @return void
     */
    public function handle(PaymentDisbursementDeleted $event)
    {
        //
    }
}

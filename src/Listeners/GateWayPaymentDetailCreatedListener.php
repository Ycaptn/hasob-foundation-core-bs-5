<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\GateWayPaymentDetail;
use Hasob\FoundationCore\Models\GateWayPaymentDetailCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GateWayPaymentDetailCreatedListener
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
     * @param  GateWayPaymentDetailCreated  $event
     * @return void
     */
    public function handle(GateWayPaymentDetailCreated $event)
    {
        //
    }
}

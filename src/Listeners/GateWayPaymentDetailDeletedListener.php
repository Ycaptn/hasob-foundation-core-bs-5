<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\GateWayPaymentDetail;
use Hasob\FoundationCore\Models\GateWayPaymentDetailDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GateWayPaymentDetailDeletedListener
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
     * @param  GateWayPaymentDetailDeleted  $event
     * @return void
     */
    public function handle(GateWayPaymentDetailDeleted $event)
    {
        //
    }
}

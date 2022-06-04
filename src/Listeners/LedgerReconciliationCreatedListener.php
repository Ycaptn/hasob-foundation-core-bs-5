<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\LedgerReconciliation;
use Hasob\FoundationCore\Models\LedgerReconciliationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LedgerReconciliationCreatedListener
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
     * @param  LedgerReconciliationCreated  $event
     * @return void
     */
    public function handle(LedgerReconciliationCreated $event)
    {
        //
    }
}

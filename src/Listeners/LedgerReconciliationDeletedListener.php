<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\LedgerReconciliation;
use Hasob\FoundationCore\Models\LedgerReconciliationDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LedgerReconciliationDeletedListener
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
     * @param  LedgerReconciliationDeleted  $event
     * @return void
     */
    public function handle(LedgerReconciliationDeleted $event)
    {
        //
    }
}

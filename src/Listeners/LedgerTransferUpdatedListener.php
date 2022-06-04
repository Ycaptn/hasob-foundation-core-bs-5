<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\LedgerTransfer;
use Hasob\FoundationCore\Models\LedgerTransferUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LedgerTransferUpdatedListener
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
     * @param  LedgerTransferUpdated  $event
     * @return void
     */
    public function handle(LedgerTransferUpdated $event)
    {
        //
    }
}

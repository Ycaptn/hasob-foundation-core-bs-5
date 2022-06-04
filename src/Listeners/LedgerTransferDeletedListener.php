<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\LedgerTransfer;
use Hasob\FoundationCore\Models\LedgerTransferDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LedgerTransferDeletedListener
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
     * @param  LedgerTransferDeleted  $event
     * @return void
     */
    public function handle(LedgerTransferDeleted $event)
    {
        //
    }
}

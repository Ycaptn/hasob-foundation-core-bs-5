<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\LedgerTransfer;
use Hasob\FoundationCore\Models\LedgerTransferCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LedgerTransferCreatedListener
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
     * @param  LedgerTransferCreated  $event
     * @return void
     */
    public function handle(LedgerTransferCreated $event)
    {
        //
    }
}

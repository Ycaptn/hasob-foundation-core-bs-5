<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\FiscalYear;
use Hasob\FoundationCore\Models\FiscalYearUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FiscalYearUpdatedListener
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
     * @param  FiscalYearUpdated  $event
     * @return void
     */
    public function handle(FiscalYearUpdated $event)
    {
        //
    }
}

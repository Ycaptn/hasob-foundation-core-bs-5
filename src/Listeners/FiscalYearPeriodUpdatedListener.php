<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\FiscalYearPeriod;
use Hasob\FoundationCore\Models\FiscalYearPeriodUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FiscalYearPeriodUpdatedListener
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
     * @param  FiscalYearPeriodUpdated  $event
     * @return void
     */
    public function handle(FiscalYearPeriodUpdated $event)
    {
        //
    }
}

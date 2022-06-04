<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\FiscalYearPeriod;
use Hasob\FoundationCore\Models\FiscalYearPeriodCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FiscalYearPeriodCreatedListener
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
     * @param  FiscalYearPeriodCreated  $event
     * @return void
     */
    public function handle(FiscalYearPeriodCreated $event)
    {
        //
    }
}

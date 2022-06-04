<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\FiscalYearPeriod;
use Hasob\FoundationCore\Models\FiscalYearPeriodDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FiscalYearPeriodDeletedListener
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
     * @param  FiscalYearPeriodDeleted  $event
     * @return void
     */
    public function handle(FiscalYearPeriodDeleted $event)
    {
        //
    }
}

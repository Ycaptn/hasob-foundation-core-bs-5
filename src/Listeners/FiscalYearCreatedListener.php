<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\FiscalYear;
use Hasob\FoundationCore\Models\FiscalYearCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FiscalYearCreatedListener
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
     * @param  FiscalYearCreated  $event
     * @return void
     */
    public function handle(FiscalYearCreated $event)
    {
        //
    }
}

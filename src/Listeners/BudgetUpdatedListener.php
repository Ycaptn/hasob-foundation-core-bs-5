<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Budget;
use Hasob\FoundationCore\Models\BudgetUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetUpdatedListener
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
     * @param  BudgetUpdated  $event
     * @return void
     */
    public function handle(BudgetUpdated $event)
    {
        //
    }
}

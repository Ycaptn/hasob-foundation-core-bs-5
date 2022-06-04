<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Budget;
use Hasob\FoundationCore\Models\BudgetCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetCreatedListener
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
     * @param  BudgetCreated  $event
     * @return void
     */
    public function handle(BudgetCreated $event)
    {
        //
    }
}

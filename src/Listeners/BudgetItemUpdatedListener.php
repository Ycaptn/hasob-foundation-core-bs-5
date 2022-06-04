<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\BudgetItem;
use Hasob\FoundationCore\Models\BudgetItemUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetItemUpdatedListener
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
     * @param  BudgetItemUpdated  $event
     * @return void
     */
    public function handle(BudgetItemUpdated $event)
    {
        //
    }
}

<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\BudgetItem;
use Hasob\FoundationCore\Models\BudgetItemCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetItemCreatedListener
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
     * @param  BudgetItemCreated  $event
     * @return void
     */
    public function handle(BudgetItemCreated $event)
    {
        //
    }
}

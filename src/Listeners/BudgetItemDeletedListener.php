<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\BudgetItem;
use Hasob\FoundationCore\Models\BudgetItemDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetItemDeletedListener
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
     * @param  BudgetItemDeleted  $event
     * @return void
     */
    public function handle(BudgetItemDeleted $event)
    {
        //
    }
}

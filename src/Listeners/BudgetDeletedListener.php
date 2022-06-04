<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Budget;
use Hasob\FoundationCore\Models\BudgetDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BudgetDeletedListener
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
     * @param  BudgetDeleted  $event
     * @return void
     */
    public function handle(BudgetDeleted $event)
    {
        //
    }
}

<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Support;
use Hasob\FoundationCore\Models\SupportDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupportDeletedListener
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
     * @param  SupportDeleted  $event
     * @return void
     */
    public function handle(SupportDeleted $event)
    {
        //
    }
}

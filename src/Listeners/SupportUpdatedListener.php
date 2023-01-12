<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Support;
use Hasob\FoundationCore\Models\SupportUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupportUpdatedListener
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
     * @param  SupportUpdated  $event
     * @return void
     */
    public function handle(SupportUpdated $event)
    {
        //
    }
}

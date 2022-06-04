<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Models\DisabledItemUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DisabledItemUpdatedListener
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
     * @param  DisabledItemUpdated  $event
     * @return void
     */
    public function handle(DisabledItemUpdated $event)
    {
        //
    }
}

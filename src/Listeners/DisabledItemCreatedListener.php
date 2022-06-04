<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Models\DisabledItemCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DisabledItemCreatedListener
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
     * @param  DisabledItemCreated  $event
     * @return void
     */
    public function handle(DisabledItemCreated $event)
    {
        //
    }
}

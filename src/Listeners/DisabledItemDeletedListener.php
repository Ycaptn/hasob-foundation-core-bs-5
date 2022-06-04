<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Models\DisabledItemDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DisabledItemDeletedListener
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
     * @param  DisabledItemDeleted  $event
     * @return void
     */
    public function handle(DisabledItemDeleted $event)
    {
        //
    }
}

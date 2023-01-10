<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Support;
use Hasob\FoundationCore\Models\SupportCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupportCreatedListener
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
     * @param  SupportCreated  $event
     * @return void
     */
    public function handle(SupportCreated $event)
    {
        //
    }
}

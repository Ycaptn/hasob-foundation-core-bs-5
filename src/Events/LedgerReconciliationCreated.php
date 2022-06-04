<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\LedgerReconciliation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LedgerReconciliationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ledgerReconciliation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LedgerReconciliation $ledgerReconciliation)
    {
        $this->ledgerReconciliation = $ledgerReconciliation;
    }

}

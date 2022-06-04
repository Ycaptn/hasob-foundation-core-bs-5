<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\BudgetItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BudgetItemCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $budgetItem;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BudgetItem $budgetItem)
    {
        $this->budgetItem = $budgetItem;
    }

}

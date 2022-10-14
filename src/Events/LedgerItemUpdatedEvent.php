<?php

namespace Hasob\FoundationCore\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;


use Hasob\FoundationCore\Models\LedgerItem;

class LedgerItemUpdatedEvent
{
    use Dispatchable, SerializesModels;

    public $ledger;

    public function __construct(LedgerItem $ledger)
    {
        $this->ledger = $ledger;
    }
}
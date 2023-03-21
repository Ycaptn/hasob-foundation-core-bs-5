<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class BatchItem extends Component
{
    public $batchable;
    public $batches;

    public function __construct($batchable)
    {
        $this->batchable = $batchable;
        $this->batches = \Hasob\FoundationCore\Models\Batch::where('status','new')->get();
    }

    public function render()
    {
        return view('hasob-foundation-core::components.batch-item')->with('batches',$this->batches);
    }
}
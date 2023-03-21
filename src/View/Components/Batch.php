<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class Batch extends Component
{
    public $batchable;
    public $control_id;

    public function __construct($batchable)
    {
        $this->control_id = "atc_".time().rand(1000,5000);
        $this->batchable = $batchable;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.create-batch');
    }
}
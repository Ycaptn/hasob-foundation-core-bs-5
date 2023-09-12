<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ReactionSelector extends Component
{
    public $control_id;
    public $reactionable;
    public $canSelect;

    public function __construct($reactionable, $canSelect=true)
    {
        $this->reactionable = $reactionable;
        $this->control_id = "ratl_".time();
        $this->canSelect = $canSelect;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.reaction-selector');
    }
}
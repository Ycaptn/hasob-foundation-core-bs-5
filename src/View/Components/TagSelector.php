<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class TagSelector extends Component
{
    public $control_id;
    public $taggable;
    public $possible_tags;

    public function __construct($taggable)
    {
        $this->control_id = "age_".time();
        $this->taggable = $taggable;
        $this->possible_tags = $taggable->tags();
    }

    public function render()
    {
        return view('hasob-foundation-core::components.tag-selector');
    }
}
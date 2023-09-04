<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class CommentEntry extends Component
{

    public $commentable;
    public $usedServiceChecker;

    public function __construct($commentableObject, $usedServiceChecker = true)
    {
        $this->commentable = $commentableObject;
        $this->usedServiceChecker = $usedServiceChecker;
    }
    
    public function render(){

        return view('hasob-foundation-core::components.comment-entry');

    }

}
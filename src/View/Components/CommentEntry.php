<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class CommentEntry extends Component
{

    public $commentable;
    public $canComment;

    public function __construct($commentableObject, $canComment = true)
    {
        $this->commentable = $commentableObject;
        $this->canComment = $canComment;
    }
    
    public function render(){

        return view('hasob-foundation-core::components.comment-entry');

    }

}
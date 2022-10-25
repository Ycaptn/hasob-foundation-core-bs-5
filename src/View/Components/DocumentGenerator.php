<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class DocumentGenerator extends Component
{
    public $control_id;
    public $target_class;
    public $document_generator;

    public function __construct($documentGenerator, $targetClass="null")
    {
        $this->control_id = "dgr_".time()."_".rand(10,20000);
        $this->document_generator = $documentGenerator;
        $this->target_class = $targetClass;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.document-generator');
    }
}
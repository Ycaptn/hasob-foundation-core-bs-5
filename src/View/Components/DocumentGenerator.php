<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class DocumentGenerator extends Component
{
    public $control_id;
    public $target_class;
    public $model_documents;
    public $document_generator;

    public function __construct($documentGenerator, $targetClass="null", $modelDocuments=[])
    {
        $this->control_id = "dgr_".time()."_".rand(10,20000);
        $this->document_generator = $documentGenerator;
        $this->target_class = $targetClass;
        $this->model_documents = $modelDocuments;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.document-generator');
    }
}
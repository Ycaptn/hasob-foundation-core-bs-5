<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class DocumentTemplateLister extends Component
{
    public $control_id;
    public $templated_model;

    public function __construct($model)
    {
        $this->control_id = "dtl_".time()."_".rand(10,20000);
        $this->templated_model = $model;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.document-template-lister');
    }
}
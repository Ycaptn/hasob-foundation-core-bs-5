<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;

class SingleArtifactEditor extends Component
{
    public $control_id;
    public $artifactable;
    public $button_label;
    public $button_class;
    public $artifact_key;
    public $artifact_label;
    public $artifact_value_type;
    public $artifact_value_default;

    public function __construct($artifactable, $artifactKey,$artifactLabel="", $buttonClass="", $buttonLabel="", $artifactValueType="string", $artifactValueDefault="N/A")
    {
        $this->control_id = "sae_".time()."_".rand(10,20000);
        $this->artifact_key = $artifactKey;
        $this->artifactable = $artifactable;
        $this->button_label = $buttonLabel;
        $this->button_class = $buttonClass;
        $this->artifact_label = $artifactLabel;
        $this->artifact_value_type = $artifactValueType;
        $this->artifact_value_default = $artifactValueDefault;
    }

    public function render()
    {
        return view('hasob-foundation-core::components.single-artifact-editor');
    }
}
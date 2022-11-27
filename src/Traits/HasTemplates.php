<?php
namespace Hasob\FoundationCore\Traits;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\DocumentGenerationTemplate;


trait HasTemplates
{

    public function has_model_templates(){
        return ModelDocument::where('model_primary_id', $this->id)
                                ->where('model_type_name', get_class($this))
                                ->count()>0;
    }

    public function get_model_templates(){
        return ModelDocument::where('model_primary_id', $this->id)
                                ->where('model_type_name', get_class($this))
                                ->get();
    }

    public function get_default_model_template(){
        return ModelDocument::where('model_primary_id', $this->id)
                                ->where('model_type_name', get_class($this))
                                ->where('is_default_template', true)
                                ->first();
    }


}

<?php
namespace Hasob\FoundationCore\Traits;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\DocumentGenerationTemplate;
use Hasob\FoundationCore\Models\Organization;


trait DocumentGenerator
{
    
    public function get_templates(){
        $model_templates = ModelDocument::where('model_type_name',self::class)
                                            ->where('is_default_template', true)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
        $templates = [];
        foreach($model_templates as $model_template){
            $templates []= $model_template->documentGenerationTemplate;
        }

        return $templates;
    }
    
}

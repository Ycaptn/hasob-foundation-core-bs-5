<?php

namespace Hasob\FoundationCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;

class ModelArtifact extends Model
{
    use GuidId;

    public $table = 'fc_model_artifacts';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'artifactable_type',
        'artifactable_id',
        'key',
        'value',
        'display_ordinal',
        'invocation_id',
        'invocation_controller_class',
        'invocation_controller_method',
        'invocation_route_name',
        'organization_id'         
    ];

    protected $casts = [
        'id' => 'string',
        'model_name' => 'string',
        'model_primary_id' => 'string',
        'key' => 'string',
        'display_ordinal' => 'integer',
        'value' => 'string',
        'invocation_id' => 'string',
        'invocation_controller_class' => 'string',
        'invocation_controller_method' => 'string',
        'invocation_route_name' => 'string',
        'organization_id' => 'string'
    ];

    
    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function actual_type(){
        if (!empty($this->model_name) && !empty($this->model_primary_id)){
            $model = new $this->model_name();
            if ($model != null){
                return $model::find($this->model_primary_id);
            }
        }
        return null;
    }

    public function artifactable(){

        return $this->morphTo();
    }
}

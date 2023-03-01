<?php

namespace Hasob\FoundationCore\Models;

use Hash;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Hasob\Workflow\Traits\Workable;
use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Pageable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Ratable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Ledgerable;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ModelDocument
 * @package Hasob\FoundationCore\Models
 * @version October 22, 2022, 4:28 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\DocumentGenerationTemplate $documentGenerationTemplate
 * @property string $id
 * @property string $organization_id
 * @property string $document_generation_template_id
 * @property string $model_primary_id
 */
class ModelDocument extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_model_documents';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'document_generation_template_id',
        'model_primary_id',
        'model_type_name',
        'is_default_template'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'model_primary_id' => 'string',
        'model_type_name' => 'string',
        'display_ordinal' => 'integer',
        'is_default_template' => 'boolean'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function documentGenerationTemplate()
    {
        return $this->belongsTo(\Hasob\FoundationCore\Models\DocumentGenerationTemplate::class, 'document_generation_template_id', 'id');
    }

}

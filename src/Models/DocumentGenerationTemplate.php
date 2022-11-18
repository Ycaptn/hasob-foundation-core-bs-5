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
 * Class DocumentGenerationTemplate
 * @package Hasob\FoundationCore\Models
 * @version October 22, 2022, 4:28 pm UTC
 *
 * @property string $organization_id
 * @property string $title
 * @property string $content
 * @property string $output_content_types
 * @property string $file_name_prefix
 * @property string $creator_user_id
 */
class DocumentGenerationTemplate extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    use SoftDeletes;
    use HasFactory;

    public $table = 'fc_document_generation_templates';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'organization_id',
        'title',
        'content',
        'output_content_types',
        'file_name_prefix',
        'creator_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'display_ordinal' => 'integer',
        'title' => 'string',
        'content' => 'string',
        'output_content_types' => 'string',
        'file_name_prefix' => 'string'
    ];


    

}

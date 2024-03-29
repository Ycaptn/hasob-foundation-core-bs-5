<?php

namespace Hasob\FoundationCore\Models;

use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Siteable;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\Commentable;
use Hasob\FoundationCore\Traits\Socialable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\CachedQuery;


class Organization extends Model
{
    use SoftDeletes;
    use Artifactable;
    use Siteable;
    use GuidId;
    use CachedQuery;

    protected $table = 'fc_organizations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'org',
        'domain',
        'full_url',
        'subdomain',
        'is_local_default_organization',
        'is_shut_down',
        'shut_down_reason',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'org' => 'string',
        'domain' => 'string',
        'full_url' => 'string',
        'is_local_default_organization' => 'boolean',
        'is_shut_down' => 'boolean',
        'shut_down_reason' => 'string'
    ];
    
    public static function all_organizations(){

        return Organization::all();
        
    }

    public function get_features(){

        $features_config = array_merge(
            config('hasob-edms.hasob_features')!=null ? config('hasob-edms.hasob_features') : [] ,
            config('hasob-scola.hasob_features')!=null ? config('hasob-scola.hasob_features') : [] ,
            config('hasob-hosting.hasob_features')!=null ? config('hasob-hosting.hasob_features') : [] ,
            config('hasob-workflow.hasob_features')!=null ? config('hasob-workflow.hasob_features') : [] ,
            config('hasob-ecommerce.hasob_features')!=null ? config('hasob-ecommerce.hasob_features') : [] ,
            config('hasob-employee-services.hasob_features')!=null ? config('hasob-employee-services.hasob_features') : [] ,
            config('hasob-quick-queue.hasob_features')!=null ? config('hasob-quick-queue.hasob_features') : [] ,
            config('tetfund-rim-module.hasob_features')!=null ? config('tetfund-rim-module.hasob_features') : [] ,
            config('hasob-foundation-core.hasob_features')!=null ? config('hasob-foundation-core.hasob_features') : [] ,
            config('hasob-scola-gradebook.hasob_features')!=null ? config('hasob-scola-gradebook.hasob_features') : [] ,
            config('tetfund-fa.hasob_features')!=null ? config('tetfund-fa.hasob_features') : [] ,
            config('tetfund-me.hasob_features')!=null ? config('tetfund-me.hasob_features') : [] ,
            config('tetfund-intervention.hasob_features')!=null ? config('tetfund-intervention.hasob_features') : [] ,
            config('tetfund-beneficiary-mgt.hasob_features')!=null ? config('tetfund-beneficiary-mgt.hasob_features') : [] ,
            config('tetfund-remote-monitoring.hasob_features')!=null ? config('tetfund-remote-monitoring.hasob_features') : [] ,
            config('hasob-lab-manager.hasob_features')!=null ? config('hasob-lab-manager.hasob_features') : [] ,
            config('iterum-biz-engine.hasob_features')!=null ? config('iterum-biz-engine.hasob_features') : [] ,
            config('tetfund-impact.hasob_features')!=null ? config('tetfund-impact.hasob_features') : [] ,
            config('tetfund-bi-submission.hasob_features')!=null ? config('tetfund-bi-submission.hasob_features') : [] ,
            config('tetfund-astd.hasob_features')!=null ? config('tetfund-astd.hasob_features') : [] ,
            config('tetfund-bims.hasob_features')!=null ? config('tetfund-bims.hasob_features') : [] ,
            config('tetfund-thesis-digitization.hasob_features')!=null ? config('tetfund-thesis-digitization.hasob_features') : [] ,
            config('tetfund-ajls.hasob_features')!=null ? config('tetfund-ajls.hasob_features') : [] ,
            config('tetfund-icdl.hasob_features')!=null ? config('tetfund-icdl.hasob_features') : [] ,
            config('tetfund-eaglescan.hasob_features')!=null ? config('tetfund-eaglescan.hasob_features') : [] ,

            config('hasob-unified-telco.hasob_features')!=null ? config('hasob-unified-telco.hasob_features') : [] ,
            config('tetfund-thesis-repository.hasob_features')!=null ? config('tetfund-thesis-repository.hasob_features') : [] ,
            config('tetfund-attendance.hasob_features')!=null ? config('tetfund-attendance.hasob_features') : [] ,

            config('tetfund-thesis-digitization-ingest.hasob_features')!=null ? config('tetfund-thesis-digitization-ingest.hasob_features') : [] ,
            config('scola-core.hasob_features')!=null ? config('scola-core.hasob_features') : [] ,
            config('scola-erecords.hasob_features')!=null ? config('scola-erecords.hasob_features') : [] ,
            config('scola-elearning.hasob_features')!=null ? config('scola-elearning.hasob_features') : [] ,
            config('scola-eclearance.hasob_features')!=null ? config('scola-eclearance.hasob_features') : [] ,
            config('scola-etranscript.hasob_features')!=null ? config('scola-etranscript.hasob_features') : [] ,
            config('scola-seminar-courses.hasob_features')!=null ? config('scola-seminar-courses.hasob_features') : [] ,
        );

        //Log::debug(config('*.hasob_features'));

        $features_saved = [];
        $artifact_record = $this->artifact('features');

        if ($artifact_record != null){
            $features_saved = json_decode($artifact_record->value, true);
        }

        $features = array_replace($features_config, $features_saved);
        //Log::debug("Features registered -> ".implode(",",array_keys($features)));

        return $features;
    }
    

}

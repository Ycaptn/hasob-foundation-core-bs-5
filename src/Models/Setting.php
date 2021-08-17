<?php

namespace Hasob\FoundationCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;

class Setting extends Model
{
    use SoftDeletes;
    use GuidId;

    public $table = 'fc_settings';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'key',
        'value',
        'group_name',
        'model_type',
        'model_value',
        'organization_id'
    ];

    protected $casts = [
        'id' => 'string',
        'key' => 'string',
        'value' => 'string',
        'group_name' => 'string',
        'model_type' => 'string',
        'model_value' => 'string',
        'organization_id' => 'string'
    ];

    
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    
    public static function get($key, Organization $org = null){

        $model = new Setting();
        $query = $model->newQuery();
        $query->where('key', $key);

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        return $query->select('value')->first();
    }

    public static function set($key, $value, Organization $org = null){

        $model = new Setting();
        $query = $model->newQuery();
        $query->where('key', $key);

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        $item = $query->first();
        if ($item != null){
            $item->value = $value;
            $item->save();
        }
    }

    public static function all_groups(Organization $org = null){

        $model = new Setting();
        $query = $model->newQuery();

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        return $query->select('group_name')->pluck('group_name')->toArray();
    }

    public static function all_settings(Organization $org = null){

        $model = new Setting();
        $query = $model->newQuery();

        if ($org!=null){
            $query->where('organization_id', $org->id);
        }

        return $query->get();
    }

}

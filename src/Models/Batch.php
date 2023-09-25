<?php

namespace Hasob\FoundationCore\Models;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Ledgerable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\Commentable;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Batch
 * @package Hasob\FoundationCore\Models
 * @version February 25, 2022, 12:29 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $id
 * @property string $organization_id
 * @property string $name
 * @property string $creator_user_id
 */
class Batch extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    use Commentable; 
    use SoftDeletes;
    use Attachable;
    use HasFactory;

    public $table = 'fc_batches';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'name',
        'batchable_type',
        'status',
        'workable_type',
        'creator_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'status' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string',
        'batchable_type' => 'string',
        'workable_type' => 'string',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->belongsTo(\Hasob\FoundationCore\Models\User::class, 'creator_user_id');
    }

    public function batchItems()
    {
        return $this->hasMany(\Hasob\FoundationCore\Models\BatchItem::class, 'batch_id','id');
    }

    public function getBatchPreview(){
        
        if($this->batchable_type != null){
            $batchable_type = new $this->batchable_type();
           return  $batchable_type->preview_batch($this->id);
        }

        return "Cannot preview batch";
    }

    public function getBatchableItems($batched_item_ids){
        
        if($this->batchable_type != null){
            $batchable_type = new $this->batchable_type();
           return  $batchable_type->get_batchable_items($batched_item_ids);
        }

        return [];
    }

    public function getBatchedItems(){
        $batchItems = $this->getBatchedItemIDs();
        if($this->batchable_type != null){
            $batchable_type = new $this->batchable_type();
           return  $batchable_type->get_batched_items($batchItems);
        }

        return [];
    }

    public function getBatchFilterItem(){
        if($this->batchable_type != null){
            $batchable_type = new $this->batchable_type();
           return  $batchable_type->get_batchable_filter_items();
        }
    }
    public function getBatchedItemIDs(){
      return  $this->batchItems()->pluck('batchable_id')->toArray();
    }
    public function getMovableBatches(){
        return Batch::where('id','<>',$this->id)->where('status','new')->where("batchable_type",$this->batchable_type)->get();
    }

    public function is_memorable(){
        $host = request()->getHost();
        $manager = new \Hasob\FoundationCore\Managers\OrganizationManager();
        $organization = $manager->loadTenant($host);

        if($this->batchable_type != null && \FoundationCore::has_feature('edms', $organization)){
           return $this->batchable_type::is_memorable();
        }

        return false;
    }

    public function get_memos(){

        if($this->is_memorable()){
            return \Hasob\EDMS\Models\Memo::where('memorable_type',get_class($this))->where('memorable_id',$this->id)->get();
        }
        return [];
        
    }


}

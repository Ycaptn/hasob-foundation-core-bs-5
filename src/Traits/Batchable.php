<?php
namespace Hasob\FoundationCore\Traits;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Models\BatchItem;
use Hasob\FoundationCore\Models\Organization;


trait Batchable
{

    public function is_batched(){
        $batches = BatchItem::where("batchable_id",$this->id)->where("batchable_type",get_class($this))->get();
        if(count($batches) > 0){
            return true;
        }
        return false;
    }

    public function get_batch(){
        
    }

    public function add_to_batch($batch_id){
      
        $batch_item =  BatchItem::create([
            'batchable_id' => $this->id,
            'batchable_type' => get_class($this),
            'batch_id' => $batch_id,
        ]);
        return $batch_item;
    }

    public function remove_from_batch($batch_id){
        BatchItem::where(
            'batchable_id',  $this->id
        )->where('batchable_type', get_class($this))->where( 'batch_id',  $batch_id)->delete();
    }

    public function move_to_batch($old_batch_id, $new_batch_id){
      
        BatchItem::where(
            'batchable_id',  $this->id
        )->where('batchable_type', get_class($this))->where( 'batch_id',  $old_batch_id)->delete();

        $batch_item = BatchItem::create([
            'batchable_id' => $this->id,
            'batchable_type' => get_class($this),
            'batch_id' => $new_batch_id,
        ]);

        return $batch_item;
    }

    public function preview_batch(){
        return "not batch preview implemented";
    }

    public function get_batchable_items(){

      $batchables = $this->all();
      $batchable_items = [];
      foreach ($batchables as $key => $value) {
        $batchable_items [] = [
            "key" => $value->id,
            "value" => $value->id,
        ];
      }

      return  $batchable_items;

    }

    public function get_batched_items($batchable_ids){

        $batchables = $this->whereIn("id",$batchable_ids)->get();
        $batched_items = [];
        foreach ($batchables as $key => $value) {
          $batched_items [] = [
              "key" => $value->id,
              "value" => $value->id,
          ];
        }
  
        return  $batched_items;
  
      }

}

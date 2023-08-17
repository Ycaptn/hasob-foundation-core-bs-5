<?php
namespace Hasob\FoundationCore\Traits;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Attachment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\ModelArtifact;


trait Artifactable
{

    public function artifacts(){
        return ModelArtifact::where('artifactable_id',$this->id)
                        ->where('artifactable_type',self::class)
                        ->orderBy('created_at')
                        ->get();
    }

    public function artifact($key){
        return ModelArtifact::where('artifactable_id',$this->id)
                        ->where('key', $key)                
                        ->where('artifactable_type', self::class)
                        ->orderBy('created_at')
                        ->first();
    }

    public function store_artifact(array $properties){
        
        if ($properties != null && count($properties)>0){

            $previous = null;

            //check if the key already exists
            if (isset($properties['key'])){
                $previous = $this->artifact($properties['key']);
            }

            if ($previous != null){
                $previous->value = $properties['value'];
                $previous->save();
                
                return $previous;

            } else {
                $properties['artifactable_type'] = self::class;
                $properties['artifactable_id'] = $this->id;
                
                return ModelArtifact::create($properties);
            }
        }

    }

}

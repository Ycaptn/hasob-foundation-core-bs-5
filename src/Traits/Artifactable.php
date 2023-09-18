<?php
namespace Hasob\FoundationCore\Traits;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Attachment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\ModelArtifact;


trait Artifactable
{

    public function artifacts(){
        if (Schema::hasColumn('fc_model_artifacts','artifactable_id')) {   
            return ModelArtifact::where('artifactable_id',$this->id)
                            ->where('artifactable_type',self::class)
                            ->orderBy('created_at')
                            ->get();
        }
        return [];
    }

    public function artifact($key){
        if (Schema::hasColumn('fc_model_artifacts','artifactable_id')) {   
            return ModelArtifact::where('artifactable_id',$this->id)
                            ->where('key', $key)                
                            ->where('artifactable_type', self::class)
                            ->orderBy('created_at')
                            ->first();
        }
        return [];
    }

    public function store_artifact(array $properties){
        if (Schema::hasColumn('fc_model_artifacts','artifactable_id')) { 
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

    /**
     * Delete model artifact by key(s)
     * 
     * @param optional string||array  $key1, $key2, $key3...
     * @return null
     */
    public function delete_artifact(){
        if (Schema::hasColumn('fc_model_artifacts','artifactable_id')) {  
             
            $args = func_get_args();  // Get all arguments as an array

            foreach ($args as $index => $key) {
    
                if(is_array($key)){
                    $flatten_keys = $this->flattenArray($key);
                    foreach ($flatten_keys as $key => $flatten_key) {
                        if(!empty($artifact = $this->artifact( $flatten_key)))
                            $artifact->delete();
                    }
                   continue;
                }
    
                if(!empty($artifact = $this->artifact($key)))
                    $artifact->delete();
            }
        }
    }

    /**
     * Flatten multidimensional array to single array
     * 
     * @param array $array
     * @return array $result;
     */
    function flattenArray($array) : array
    {
        $result = [];

        foreach ($array as $element) {
            if (is_array($element)) {
                $result = array_merge($result, flattenArray($element));
            } else {
                $result[] = $element;
            }
        }

        return $result;
    }

}

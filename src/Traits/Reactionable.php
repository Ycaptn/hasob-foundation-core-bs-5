<?php
namespace Hasob\FoundationCore\Traits;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Page;
use Hasob\FoundationCore\Models\Reaction;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;


trait Reactionable
{

    public function reactions(){
        $reactions = Reaction::where('reactionable_id',$this->id)
                            ->where('reactionable_type',self::class)
                            ->orderBy('created_at')
                            ->get();
        return $reactions;
    }

    public function create_like(User $user){

        //create reaction
        $reaction = new Reaction();
        $reaction->creator_user_id = $user->id;
        $reaction->organization_id = $user->organization_id;
        $reaction->reactionable_id = self::class;
        $reaction->reactionable_type = $this->id;
        $reaction->is_liked = 1;
        $reaction->save();

        return $reaction;
    }

    public function create_dislike(User $user){

        //create reaction
        $reaction = new Reaction();
        $reaction->creator_user_id = $user->id;
        $reaction->organization_id = $user->organization_id;
        $reaction->reactionable_id = self::class;
        $reaction->reactionable_type = $this->id;
        $reaction->is_not_liked = 1;
        $reaction->save();

        return $reaction;
    }

    public function likes_count(){
        $result = Reaction::where('reactionable_id',$this->id)
                                ->where('reactionable_type',self::class)
                                ->where('is_liked', 1)
                                ->count();
        return $result;
    }

    public function dislikes_count(){
        $result = Reaction::where('reactionable_id',$this->id)
                                ->where('reactionable_type',self::class)
                                ->where('is_not_liked', 1)
                                ->count();
        return $result;
    }
}
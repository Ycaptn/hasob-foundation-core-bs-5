<?php
namespace Hasob\FoundationCore\Traits;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;


trait Disable
{
    public function is_disabled(){

        $disabled_item = DisabledItem::where('disable_id', $this->id)
                                            ->where('disable_type', self::class)
                                            ->where('is_current', true)
                                            ->first();

        if ($disabled_item != null){
            return ($disabled_item->is_disabled==true);
        }
        return false;
    }

    public function is_enabled(){

        $disabled_item = DisabledItem::where('disable_id', $this->id)
                                        ->where('disable_type', self::class)
                                        ->where('is_current', true)
                                        ->first();

        if ($disabled_item != null){
            return ($disabled_item->is_disabled==false);
        }
        return true;
    }

    public function disable($comments, User $user = null){

        if ($user == null){
            $user = Auth()->user();
        }

        foreach(DisabledItem::where([
            'disable_id'=>$this->id,
            'disable_type'=>self::class])->get() as $item){
                $item->is_current = false;
                $item->save();
        }

        $disabledItem = new DisabledItem();
        $disabledItem->disable_id = $this->id;
        $disabledItem->disable_type = self::class;
        $disabledItem->is_current = true;
        $disabledItem->is_disabled = true;
        $disabledItem->disable_reason = $comments;
        $disabledItem->disabled_at = Carbon::now();
        $disabledItem->disabling_user_id = $user->id;
        $disabledItem->organization_id = $user->organization_id;
        $disabledItem->save();
    }

    public function enable($comments, User $user = null){

        if ($user == null){
            $user = Auth()->user();
        }

        foreach(DisabledItem::where([
            'disable_id'=>$this->id,
            'disable_type'=>self::class])->get() as $item){
                $item->is_current = false;
                $item->save();
        }

        $disabledItem = new DisabledItem();
        $disabledItem->disable_id = $this->id;
        $disabledItem->disable_type = self::class;
        $disabledItem->is_current = true;
        $disabledItem->is_disabled = false;
        $disabledItem->disable_reason = $comments;
        $disabledItem->disabled_at = Carbon::now();
        $disabledItem->disabling_user_id = $user->id;
        $disabledItem->organization_id = $user->organization_id;
        $disabledItem->save();
    }
}

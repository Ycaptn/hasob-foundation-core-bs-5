<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\Component;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Ledger;
use Hasob\FoundationCore\Models\Comment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\ChecklistTemplate;


class ChecklistEditor extends Component
{
    public $control_id;
    public $attribute_groups;
    public $checklists;
    public $selected_name;
    public $selected_template_items;

    public function __construct(Organization $org, Request $request, $attributeGroups)
    {
        $this->control_id = "ckle_".time();
        $this->selected_template_items = [];
        $this->selected_name = $request->name;
        $this->attribute_groups = $attributeGroups;

        $this->checklists = ChecklistTemplate::where('organization_id',$org->id)->groupBy('list_name')->pluck('list_name');
        if ($this->selected_name!=null){
            $this->selected_template_items = ChecklistTemplate::where('list_name',$this->selected_name)
                                                            ->orderBy('ordinal','asc')
                                                            ->get();
        }
    }

    public function render()
    {
        return view('hasob-foundation-core::components.checklist-editor')
                    ->with('checklists', $this->checklists)
                    ->with('attribute_groups', $this->attribute_groups)
                    ->with('selected_checklist_name', $this->selected_name)
                    ->with('selected_idx_max', count($this->selected_template_items))
                    ->with('selected_checklist_items', $this->selected_template_items);
    }
}
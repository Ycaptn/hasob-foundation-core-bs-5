<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\View\Component;
use Hasob\FoundationCore\Models\Department;

class DepartmentSelector extends Component
{

    public $control_id;
    public $department_user;
    public $available_departments;

    public function __construct($user)
    {
        $this->department_user = $user;
        $this->control_id = "dsr_".time();
        $this->available_departments = Department::all();
    }


    public function render()
    {
        return view('hasob-foundation-core::components.department-selector');
    }
}
<?php

namespace Hasob\FoundationCore\DataTables;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Organization;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class UserDataTable extends DataTable
{

    protected $organization;

    public function __construct(Organization $org=null){
        $this->organization = $org;
    }
    
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        $dataTable->addColumn('no', function ($query) {
            return "{$query->ranking_ordinal}";
        });

        $dataTable->addColumn('user', function ($query) {
            
            $disabled = null;
            if ($query->is_disabled){
                $disabled = "<span class='text-danger small'>&nbsp<i>(Disabled)</i></span>";
            }
            
            $name = "{$query->first_name} {$query->middle_name} {$query->last_name} {$disabled}";
            if ($query->department != null){
                $name .= "<br/><span class='text-success small'>{$query->department->long_name}</span>";
            }
            return $name;
        });


        $dataTable->addColumn('last_login', function ($query) {
            if ($query->last_loggedin_at != null){
                return $query->last_loggedin_at->diffForHumans();
            }
            return "Never";
        });

        $dataTable->addColumn('roles', function ($query) {

            $roleList = [];
            $userRoles = $query->getRoleNames();
            
            foreach ($userRoles as $idx=>$roleName){
                $roleList []= "<span class='label label-primary'>{$roleName}</span>";
            }

            return implode("&nbsp;", $roleList);
        });

        $dataTable->addColumn('action', 'hasob-foundation-core::users.action_buttons');
        $dataTable->rawColumns(['user','roles','action']);

        return $dataTable;
    }

    public function query(User $model)
    {
        if ($this->organization != null){
            return User::where("organization_id", "{$this->organization->id}")->select("fc_users.*"); 
        }
        
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '50px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                // 'buttons'   => [
                //     ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                //     ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                //     ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                //     ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                //     ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                // ],
            ]);
    }

    protected function getColumns()
    {
        return [
            'no',
            'user',
            'email',
            'telephone',
            'roles',
            'last_login'
        ];
    }

    protected function filename()
    {
        return 'users_datatable_' . time();
    }
}

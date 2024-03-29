<?php

namespace Hasob\FoundationCore\DataTables;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Organization;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;


class RoleDataTable extends DataTable
{

    protected $organization;

    public function __construct(Organization $org=null){
        $this->organization = $org;
    }
    
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->addColumn('role', function($query)
        {
            return "{$query->name}";
        })->filterColumn('name', function ($query, $keyword){
                             
            $query->where('name','like','%'.$keyword.'%');
             
        });
      

        $dataTable->addColumn('action', 'hasob-foundation-core::roles.action_buttons');
        $dataTable->rawColumns(['action']);

        return $dataTable;
    }

    public function query(Role $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            'id',
            ['title'=>'Role', 'data'=> "name",'searchable' => 'true'],
            //'last_login_date'
        ];
    }

    protected function filename()
    {
        return 'roles_datatable_' . time();
    }
}

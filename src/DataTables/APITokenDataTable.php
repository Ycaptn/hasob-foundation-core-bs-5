<?php

namespace Hasob\FoundationCore\DataTables;

use Laravel\Sanctum\PersonalAccessToken;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

use Hasob\FoundationCore\Models\Organization;

class APITokenDataTable extends DataTable
{

    protected $organization;

    public function __construct(Organization $organization){
        $this->organization = $organization;
    }

    public function dataTable($query) {
        $dataTable = new EloquentDataTable($query);

        // modify token owner
        $dataTable->addColumn('token_owner', function ($query) {
            return empty($query->tokenable) ?  "N/A" :
                $query->tokenable->full_name .'<br>'.
                '<small class="text-danger">'. $query->tokenable->email. '</small>';
        })->escapeColumns('active')->make(true);


        // modify name & type
        $dataTable->addColumn('name_and_type', function ($query) {
            $str_returned = "<b>TOKEN NAME:</b><br>";
            
            $str_returned .= empty($query->name) ?  "&nbsp; -- N/A" :
                                "&nbsp; -- {$query->name}";

            $str_returned .= "<br><b>TOKEN TYPE:</b><br>";
            $str_returned .= empty($query->tokenable_type) ?  "&nbsp; -- N/A" :
                                "&nbsp; -- {$query->tokenable_type}";
                                
            return '<small>'. $str_returned .'</small>';
        })->escapeColumns('active')->make(true);


        // modify date_stamps
        $dataTable->addColumn('date_stamps', function ($query) {
            $str_returned = "<b>CREATED AT:</b><br>";
            
            $str_returned .= empty($query->created_at) ?  "&nbsp; -- N/A" :
                                '&nbsp;'.
                                date("-- jS M, Y", strtotime($query->created_at)) .'<br> &nbsp;'.
                                date("-- h:i:s a", strtotime($query->created_at));

            $str_returned .= "<br><b>LAST USED:</b><br>";
            $str_returned .= empty($query->last_used_at) ?  "&nbsp; -- N/A" :
                                '&nbsp;'.
                                date("-- jS M, Y", strtotime($query->last_used_at)) .'<br> &nbsp;'.
                                date("-- h:i:s a", strtotime($query->last_used_at)) ;

            return '<small>'. $str_returned .'</small>';
        })->escapeColumns('active')->make(true);

        return $dataTable->addColumn('action', 'hasob-foundation-core::api_tokens.action_buttons');
    }

   
    public function query(PersonalAccessToken $model) {
        if (!empty($this->organization)){
            return $model->newQuery()
                    ->with('tokenable')
                    ->select(['*', 'token AS visible_column'])
                    ->whereHas('tokenable', function($query) {
                        return $query->where('organization_id', optional($this->organization)->id);
                    });
        }

        return $model->newQuery()->select(['*', 'token AS visible_column'])->with('tokenable');
    }

    public function html() {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[2, 'desc']],
                'buttons'   => [
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                ],
            ]);
    }

   
    protected function getColumns() {
        return [
            ['title'=>'Token Owner','data'=>'token_owner', 'name'=>'tokenable.email'],
            ['title'=>'Token Name & Type','data'=>'name_and_type', 'name'=>'name'],
            ['title'=>'Token Time Stamps ','data'=>'date_stamps', 'name'=>'created_at'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tags_datatable_' . time();
    }
}

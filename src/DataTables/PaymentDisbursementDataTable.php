<?php

namespace Hasob\FoundationCore\DataTables;

use Hasob\FoundationCore\Models\PaymentDisbursement;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

use Hasob\FoundationCore\Models\Organization;

class PaymentDisbursementDataTable extends DataTable
{
    protected $organization;

    public function __construct(Organization $organization){
        $this->organization = $organization;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'hasob-foundationcore.payment_disbursements.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PaymentDisbursement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PaymentDisbursement $model)
    {
        if ($this->organization != null){
            return $model->newQuery()->where("organization_id", $this->organization->id);
        }
        
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-outline btn-xs no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'amount',
            'payable_type',
            'payable_id',
            'bank_account_number',
            'bank_name',
            'bank_sort_code',
            'gateway_reference_code',
            'status',
            'gateway_initialization_response',
            'payment_instrument_type',
            'payment_instrument_type',
            'is_verified',
            'is_verification_passed',
            'is_verification_failed',
            'transaction_date',
            'verified_amount',
            'verification_meta',
            'verification_notes'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'payment_disbursements_datatable_' . time();
    }
}

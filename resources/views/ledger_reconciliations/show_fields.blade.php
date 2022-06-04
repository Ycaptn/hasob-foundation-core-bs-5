<!-- Name Field -->
<div id="div_ledgerReconciliation_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerReconciliation_name">
        @if (isset($ledgerReconciliation->name) && empty($ledgerReconciliation->name)==false)
            {!! $ledgerReconciliation->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_ledgerReconciliation_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerReconciliation_status">
        @if (isset($ledgerReconciliation->status) && empty($ledgerReconciliation->status)==false)
            {!! $ledgerReconciliation->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Closing Balance Amount Field -->
<div id="div_ledgerReconciliation_closing_balance_amount" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('closing_balance_amount', 'Closing Balance Amount:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerReconciliation_closing_balance_amount">
        @if (isset($ledgerReconciliation->closing_balance_amount) && empty($ledgerReconciliation->closing_balance_amount)==false)
            {!! $ledgerReconciliation->closing_balance_amount !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Start Date Field -->
<div id="div_ledgerReconciliation_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerReconciliation_start_date">
        @if (isset($ledgerReconciliation->start_date) && empty($ledgerReconciliation->start_date)==false)
            {!! $ledgerReconciliation->start_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_ledgerReconciliation_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerReconciliation_end_date">
        @if (isset($ledgerReconciliation->end_date) && empty($ledgerReconciliation->end_date)==false)
            {!! $ledgerReconciliation->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


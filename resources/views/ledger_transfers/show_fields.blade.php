<!-- Name Field -->
<div id="div_ledgerTransfer_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerTransfer_name">
        @if (isset($ledgerTransfer->name) && empty($ledgerTransfer->name)==false)
            {!! $ledgerTransfer->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_ledgerTransfer_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerTransfer_status">
        @if (isset($ledgerTransfer->status) && empty($ledgerTransfer->status)==false)
            {!! $ledgerTransfer->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Closing Balance Amount Field -->
<div id="div_ledgerTransfer_closing_balance_amount" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('closing_balance_amount', 'Closing Balance Amount:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerTransfer_closing_balance_amount">
        @if (isset($ledgerTransfer->closing_balance_amount) && empty($ledgerTransfer->closing_balance_amount)==false)
            {!! $ledgerTransfer->closing_balance_amount !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Start Date Field -->
<div id="div_ledgerTransfer_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerTransfer_start_date">
        @if (isset($ledgerTransfer->start_date) && empty($ledgerTransfer->start_date)==false)
            {!! $ledgerTransfer->start_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_ledgerTransfer_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_ledgerTransfer_end_date">
        @if (isset($ledgerTransfer->end_date) && empty($ledgerTransfer->end_date)==false)
            {!! $ledgerTransfer->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


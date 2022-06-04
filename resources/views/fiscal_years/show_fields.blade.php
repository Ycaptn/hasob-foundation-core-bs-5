<!-- Name Field -->
<div id="div_fiscalYear_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYear_name">
        @if (isset($fiscalYear->name) && empty($fiscalYear->name)==false)
            {!! $fiscalYear->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_fiscalYear_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYear_status">
        @if (isset($fiscalYear->status) && empty($fiscalYear->status)==false)
            {!! $fiscalYear->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Start Date Field -->
<div id="div_fiscalYear_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYear_start_date">
        @if (isset($fiscalYear->start_date) && empty($fiscalYear->start_date)==false)
            {!! $fiscalYear->start_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_fiscalYear_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYear_end_date">
        @if (isset($fiscalYear->end_date) && empty($fiscalYear->end_date)==false)
            {!! $fiscalYear->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


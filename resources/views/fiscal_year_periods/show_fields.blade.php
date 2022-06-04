<!-- Name Field -->
<div id="div_fiscalYearPeriod_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYearPeriod_name">
        @if (isset($fiscalYearPeriod->name) && empty($fiscalYearPeriod->name)==false)
            {!! $fiscalYearPeriod->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_fiscalYearPeriod_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYearPeriod_status">
        @if (isset($fiscalYearPeriod->status) && empty($fiscalYearPeriod->status)==false)
            {!! $fiscalYearPeriod->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Start Date Field -->
<div id="div_fiscalYearPeriod_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYearPeriod_start_date">
        @if (isset($fiscalYearPeriod->start_date) && empty($fiscalYearPeriod->start_date)==false)
            {!! $fiscalYearPeriod->start_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- End Date Field -->
<div id="div_fiscalYearPeriod_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_fiscalYearPeriod_end_date">
        @if (isset($fiscalYearPeriod->end_date) && empty($fiscalYearPeriod->end_date)==false)
            {!! $fiscalYearPeriod->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


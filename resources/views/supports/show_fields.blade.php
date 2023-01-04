<!-- Label Field -->
<div id="div_support_location" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('location', 'Location:', ['class'=>'control-label']) !!} 
        <span id="spn_support_label">
        @if (isset($support->location) && empty($support->location)==false)
            {!! $support->location !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Support Type Field -->
<div id="div_support_support_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('support_type', 'Support Type:', ['class'=>'control-label']) !!} 
        <span id="spn_support_support_type">
        @if (isset($support->support_type) && empty($support->support_type)==false)
            {!! $support->support_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Issue Type Field -->
<div id="div_support_issue_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('issue_type', 'Support Type:', ['class'=>'control-label']) !!} 
        <span id="spn_support_issue_type">
        @if (isset($support->issue_type) && empty($support->issue_type)==false)
            {!! $support->issue_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Severity Field -->
<div id="div_support_severity" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('severity', 'Severity:', ['class'=>'control-label']) !!} 
        <span id="spn_support_severity">
        @if (isset($support->severity) && empty($support->severity)==false)
            {!! $support->severity !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_support_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_support_description">
        @if (isset($support->description) && empty($support->description)==false)
            {!! $support->description !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Down Field -->
<div id="div_support_status" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('status', 'status:', ['class'=>'control-label']) !!} 
        <span id="spn_support_status">
        @if (isset($support->status) && empty($support->status)==false)
            {!! $support->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

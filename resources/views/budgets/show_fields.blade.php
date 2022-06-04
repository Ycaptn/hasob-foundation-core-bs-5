<!-- Name Field -->
<div id="div_budget_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_budget_name">
        @if (isset($budget->name) && empty($budget->name)==false)
            {!! $budget->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Code Field -->
<div id="div_budget_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_budget_code">
        @if (isset($budget->code) && empty($budget->code)==false)
            {!! $budget->code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Group Field -->
<div id="div_budget_group" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('group', 'Group:', ['class'=>'control-label']) !!} 
        <span id="spn_budget_group">
        @if (isset($budget->group) && empty($budget->group)==false)
            {!! $budget->group !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Type Field -->
<div id="div_budget_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('type', 'Type:', ['class'=>'control-label']) !!} 
        <span id="spn_budget_type">
        @if (isset($budget->type) && empty($budget->type)==false)
            {!! $budget->type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


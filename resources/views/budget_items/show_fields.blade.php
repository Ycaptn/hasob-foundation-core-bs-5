<!-- Title Field -->
<div id="div_budgetItem_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_title">
        @if (isset($budgetItem->title) && empty($budgetItem->title)==false)
            {!! $budgetItem->title !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Code Field -->
<div id="div_budgetItem_code" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('code', 'Code:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_code">
        @if (isset($budgetItem->code) && empty($budgetItem->code)==false)
            {!! $budgetItem->code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Group Field -->
<div id="div_budgetItem_group" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('group', 'Group:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_group">
        @if (isset($budgetItem->group) && empty($budgetItem->group)==false)
            {!! $budgetItem->group !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Type Field -->
<div id="div_budgetItem_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('type', 'Type:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_type">
        @if (isset($budgetItem->type) && empty($budgetItem->type)==false)
            {!! $budgetItem->type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Location Field -->
<div id="div_budgetItem_location" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('location', 'Location:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_location">
        @if (isset($budgetItem->location) && empty($budgetItem->location)==false)
            {!! $budgetItem->location !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Description Field -->
<div id="div_budgetItem_description" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('description', 'Description:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_description">
        @if (isset($budgetItem->description) && empty($budgetItem->description)==false)
            {!! $budgetItem->description !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Allocated Amount Field -->
<div id="div_budgetItem_allocated_amount" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('allocated_amount', 'Allocated Amount:', ['class'=>'control-label']) !!} 
        <span id="spn_budgetItem_allocated_amount">
        @if (isset($budgetItem->allocated_amount) && empty($budgetItem->allocated_amount)==false)
            {!! $budgetItem->allocated_amount !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


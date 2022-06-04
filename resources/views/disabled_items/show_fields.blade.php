<!-- Disable Id Field -->
<div id="div_disabledItem_disable_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('disable_id', 'Disable Id:', ['class'=>'control-label']) !!} 
        <span id="spn_disabledItem_disable_id">
        @if (isset($disabledItem->disable_id) && empty($disabledItem->disable_id)==false)
            {!! $disabledItem->disable_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Disable Reason Field -->
<div id="div_disabledItem_disable_reason" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('disable_reason', 'Disable Reason:', ['class'=>'control-label']) !!} 
        <span id="spn_disabledItem_disable_reason">
        @if (isset($disabledItem->disable_reason) && empty($disabledItem->disable_reason)==false)
            {!! $disabledItem->disable_reason !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


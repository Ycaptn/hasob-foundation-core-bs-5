<!-- Model Primary Id Field -->
<div id="div_modelDocument_model_primary_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('model_primary_id', 'Model Primary Id:', ['class'=>'control-label']) !!} 
        <span id="spn_modelDocument_model_primary_id">
        @if (isset($modelDocument->model_primary_id) && empty($modelDocument->model_primary_id)==false)
            {!! $modelDocument->model_primary_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


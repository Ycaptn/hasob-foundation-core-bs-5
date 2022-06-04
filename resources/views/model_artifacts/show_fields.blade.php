<!-- Model Primary Id Field -->
<div id="div_modelArtifact_model_primary_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('model_primary_id', 'Model Primary Id:', ['class'=>'control-label']) !!} 
        <span id="spn_modelArtifact_model_primary_id">
        @if (isset($modelArtifact->model_primary_id) && empty($modelArtifact->model_primary_id)==false)
            {!! $modelArtifact->model_primary_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Key Field -->
<div id="div_modelArtifact_key" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('key', 'Key:', ['class'=>'control-label']) !!} 
        <span id="spn_modelArtifact_key">
        @if (isset($modelArtifact->key) && empty($modelArtifact->key)==false)
            {!! $modelArtifact->key !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Value Field -->
<div id="div_modelArtifact_value" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('value', 'Value:', ['class'=>'control-label']) !!} 
        <span id="spn_modelArtifact_value">
        @if (isset($modelArtifact->value) && empty($modelArtifact->value)==false)
            {!! $modelArtifact->value !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


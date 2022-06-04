<!-- Model Primary Id Field -->
<div id="div-model_primary_id" class="form-group">
    <label for="model_primary_id" class="col-lg-3 col-form-label">Model Primary Id</label>
    <div class="col-lg-9">
        {!! Form::text('model_primary_id', null, ['id'=>'model_primary_id', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Key Field -->
<div id="div-key" class="form-group">
    <label for="key" class="col-lg-3 col-form-label">Key</label>
    <div class="col-lg-9">
        {!! Form::text('key', null, ['id'=>'key', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Value Field -->
<div id="div-value" class="form-group">
    <label for="value" class="col-lg-3 col-form-label">Value</label>
    <div class="col-lg-9">
        {!! Form::text('value', null, ['id'=>'value', 'class' => 'form-control','maxlength' => 2000]) !!}
    </div>
</div>
<!-- Disable Id Field -->
<div id="div-disable_id" class="form-group">
    <label for="disable_id" class="col-lg-3 col-form-label">Disable Id</label>
    <div class="col-lg-9">
        {!! Form::text('disable_id', null, ['id'=>'disable_id', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Disable Reason Field -->
<div id="div-disable_reason" class="form-group">
    <label for="disable_reason" class="col-lg-3 col-form-label">Disable Reason</label>
    <div class="col-lg-9">
        {!! Form::text('disable_reason', null, ['id'=>'disable_reason', 'class' => 'form-control','maxlength' => 500]) !!}
    </div>
</div>
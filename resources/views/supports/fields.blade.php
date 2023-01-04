<!-- Label Field -->
<div id="div-location" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="label">Label</label>
    <div class="col-sm-12">
        {!! Form::text('location', null, ['id' => 'location','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Support Type Field -->
<div id="div-support_type" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="support_type">Contact Person</label>
    <div class="col-sm-12 mb-3">
        {!! Form::text('support_type', null, ['id' => 'support_type','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Issue Type Field -->
<div id="div-issue_type" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="issue_type">Street</label>
    <div class="col-sm-12">
        {!! Form::text('issue_type', null, ['id' => 'issue_type','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Designated Department Field -->
<div id="div-designated_department_id" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="town">Town</label>
    <div class="col-sm-12">
        {!! Form::text('designated_department_id', null, ['id' => 'designated_department_id','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Severity Field -->
<div id="div-severity" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="severity">Severity</label>
    <div class="col-sm-12">
        {!! Form::text('severity', null, ['id' => 'severity','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">description</label>
    <div class="col-sm-12">
        {!! Form::textarea('description', null, [ 'id' => 'description', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

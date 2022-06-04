<!-- Name Field -->
<div id="div-name" class="form-group">
    <label for="name" class="col-lg-3 col-form-label">Name</label>
    <div class="col-lg-9">
        {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control','minlength' => 4,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Is Current Field -->
<div id="div-is_current" class="form-group">
    <label for="is_current" class="col-lg-3 col-form-label">Is Current</label>
    <div class="col-lg-9">
        {!! Form::text('is_current', null, ['id'=>'is_current', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Status Field -->
<div id="div-status" class="form-group">
    <label for="status" class="col-lg-3 col-form-label">Status</label>
    <div class="col-lg-9">
        {!! Form::text('status', null, ['id'=>'status', 'class' => 'form-control','minlength' => 4,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Start Date Field -->
<div id="div-start_date" class="form-group">
    <label for="start_date" class="col-lg-3 col-form-label">Start Date</label>
    <div class="col-lg-9">
        {!! Form::text('start_date', null, ['id'=>'start_date', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- End Date Field -->
<div id="div-end_date" class="form-group">
    <label for="end_date" class="col-lg-3 col-form-label">End Date</label>
    <div class="col-lg-9">
        {!! Form::text('end_date', null, ['id'=>'end_date', 'class' => 'form-control']) !!}
    </div>
</div>
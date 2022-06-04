<!-- Parent Id Field -->
<div id="div-parent_id" class="form-group">
    <label for="parent_id" class="col-lg-3 col-form-label">Parent Id</label>
    <div class="col-lg-9">
        {!! Form::text('parent_id', null, ['id'=>'parent_id', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div id="div-name" class="form-group">
    <label for="name" class="col-lg-3 col-form-label">Name</label>
    <div class="col-lg-9">
        {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control','maxlength' => 50]) !!}
    </div>
</div>

<!-- Meta Data Field -->
<div id="div-meta_data" class="form-group">
    <label for="meta_data" class="col-lg-3 col-form-label">Meta Data</label>
    <div class="col-lg-9">
        {!! Form::text('meta_data', null, ['id'=>'meta_data', 'class' => 'form-control']) !!}
    </div>
</div>
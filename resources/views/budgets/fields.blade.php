<!-- Name Field -->
<div id="div-name" class="form-group">
    <label for="name" class="col-lg-3 col-form-label">Name</label>
    <div class="col-lg-9">
        {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Code Field -->
<div id="div-code" class="form-group">
    <label for="code" class="col-lg-3 col-form-label">Code</label>
    <div class="col-lg-9">
        {!! Form::text('code', null, ['id'=>'code', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Group Field -->
<div id="div-group" class="form-group">
    <label for="group" class="col-lg-3 col-form-label">Group</label>
    <div class="col-lg-9">
        {!! Form::text('group', null, ['id'=>'group', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Type Field -->
<div id="div-type" class="form-group">
    <label for="type" class="col-lg-3 col-form-label">Type</label>
    <div class="col-lg-9">
        {!! Form::text('type', null, ['id'=>'type', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>
<!-- Title Field -->
<div id="div-title" class="form-group">
    <label for="title" class="col-lg-3 col-form-label">Title</label>
    <div class="col-lg-9">
        {!! Form::text('title', null, ['id'=>'title', 'class' => 'form-control','maxlength' => 200]) !!}
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

<!-- Location Field -->
<div id="div-location" class="form-group">
    <label for="location" class="col-lg-3 col-form-label">Location</label>
    <div class="col-lg-9">
        {!! Form::text('location', null, ['id'=>'location', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Description Field -->
<div id="div-description" class="form-group">
    <label for="description" class="col-lg-3 col-form-label">Description</label>
    <div class="col-lg-9">
        {!! Form::text('description', null, ['id'=>'description', 'class' => 'form-control','maxlength' => 2000]) !!}
    </div>
</div>

<!-- Start Allocated Amount Field -->
<div id="div-allocated_amount" class="row mb-3">
    <label for="allocated_amount" class="col-lg-3 col-form-label">Allocated Amount</label>
    <div class="col-sm-9">
        {!! Form::number('allocated_amount', null, ['id'=>'allocated_amount', 'class' => 'form-control','min' => 1,'max' => 1000000000000]) !!}
    </div>
</div>
<!-- End Allocated Amount Field -->
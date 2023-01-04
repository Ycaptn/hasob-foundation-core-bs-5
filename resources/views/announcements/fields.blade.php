<!-- Label Field -->
<div id="div-headline" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="headline">Headline</label>
    <div class="col-sm-12">
        {!! Form::text('headline', null, ['id' => 'headline','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Contact Person Field -->
<div id="div-content" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="content">Content</label>
    <div class="col-sm-12">
        {!! Form::textarea('content', null, ['id' => 'content','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- start_date Field -->
<div id="div-start_date" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="start_date">Start Date</label>
    <div class="col-sm-12">
        {!! Form::text('start_date', null, ['id' => 'start_date','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- end_date Field -->
<div id="div-end_date" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="end_date">End Date</label>
    <div class="col-sm-12">
        {!! Form::text('end_date', null, ['id' => 'end_date','class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>



<!-- Title Field -->
<div id="div-title" class="form-group">
    <label for="title" class="col-lg-3 col-form-label">Title</label>
    <div class="col-lg-12">
        {!! Form::text('title', null, ['id'=>'title', 'class' => 'form-control','minlength' => 4,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Content Field -->
<div id="div-content" class="form-group">
    <label for="content" class="col-lg-3 col-form-label">Content</label>
    <div class="col-lg-12">
        <textarea id="content" name="content" class="form-control" rows="13"></textarea>
        {{-- {!! Form::text('content', null, ['id'=>'content', 'class' => 'form-control','minlength' => 0,'maxlength' => 2000]) !!} --}}
    </div>
</div>
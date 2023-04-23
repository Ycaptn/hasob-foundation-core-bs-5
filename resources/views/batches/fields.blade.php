<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="name">Name</label>
    <div class="col-sm-12">
        {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>

<div id="div-batch-workables" class="form-group">
    <label class="control-label mb-10 col-sm-3">Type</label>
    <select name="sel_workable_type" id="sel_workable_type" class="form-select">
    <option value="">-- Select Batch proccessing type--</option>
        @foreach (\FoundationCore::get_batch_workables($organization) as $idx => $model)
            <option value="{{ $model->value }}">{{ $model->key }}</option>
        @endforeach
    </select>
</div>

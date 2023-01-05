<!-- Support Type Field -->
<div id="div-support_type" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="support_type">Support Type</label>
    <div class="col-sm-12 mb-3">
        {!! Form::text('support_type', null, ['id' => 'support_type', 'class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>


<!-- Issue Type Field -->
<div id="div-issue_type" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="issue_type">Issue Type</label>
    <div class="col-sm-12">
        {!! Form::text('issue_type', null, ['id' => 'issue_type', 'class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>


<!-- Location Field -->
<div id="div-location" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="label">Location</label>
    <div class="col-sm-12">
        {!! Form::text('location', null, ['id' => 'location', 'class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>

<!-- Designated Department Field -->
<div id="div-designated_department_id" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="town">Destination Department</label>
    <div class="col-sm-12">
        <select class="form-select" name="designation_department_id" id="designation_department_id">
            <option value="">Select department</option>
            @foreach ($departments as $department)
                <option value="{{$department->id}}">{{ $department->long_name }}</option>
            @endforeach
        </select>
       
    </div>
</div>




<!-- Severity Field -->
<div id="div-severity" class="form-group mb-3">
    <label class="control-label mb-10 col-sm-3" for="severity">Severity</label>
    <div class="col-sm-12">
        <select class="form-select" name="severity" id="severity">
            <option value=""> -- select severity -- </option>
            <option value="low"> Low </option>
            <option value="medium">Medium</option>
            <option value="high"> High </option>
        </select>
    </div>
</div>

<!-- description Field -->
<div id="div-description" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="description">Description</label>
    <div class="col-sm-12">
        {!! Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control', 'maxlength' => 200]) !!}
    </div>
</div>

<!-- Key Field -->
{{-- <div id="div-key" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="key">Key</label>
    <div class="col-sm-9">
        {!! Form::text('key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div> --}}

<!-- Long Name Field -->
<div id="div-long_name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="long_name">Name</label>
    <div class="col-sm-9">
        {!! Form::text('long_name', null, ['id'=>'long_name', 'class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-xs-3 control-label">Parent</label>
    <div class="col-xs-9">
        <div class="input-group">
            <select id="department_id" name="department_id" class="form-control">
                <option value="0">None</option>
                @if (isset($departments) && $departments != null)
                    @foreach ($departments as $idx=>$dept)
                        <option value="{{$dept->key}}">{{$dept->long_name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="input-group-addon"><span class="fa fa-institution"></span></span>
        </div>
    </div>
</div>


<!-- Is Unit Field -->
<div id="div-is_unit" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_unit">Unit</label>
    <div class="col-sm-9">
        <div class="form-check">
            {!! Form::hidden('is_unit', 0, ['id'=>'is_unit', 'class' => 'form-check-input']) !!}
            {!! Form::checkbox('is_unit', '1', null, ['id'=>'is_unit', 'class' => 'form-check-input']) !!}
        </div>
    </div>
</div>

<!-- Email Field -->
<div id="div-email" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="email">Email</label>
    <div class="col-sm-5">
        {!! Form::email('email', null, ['id'=>'email', 'class' => 'form-control','placeholder'=>'Department Email','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text('telephone', null, ['id'=>'telephone', 'class' => 'form-control','placeholder'=>'Phone Number','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>


<!-- Physical Location Field -->
<div id="div-physical_location" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="physical_location">Physical Location</label>
    <div class="col-sm-9">
        {!! Form::text('physical_location', null, ['id'=>'physical_location', 'class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div>

<!-- Logo Image Field -->
{{-- <div id="div-logo_image" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="logo_image">Logo Image</label>
    <div class="col-sm-9">
        {!! Form::text('logo_image', null, ['class' => 'form-control','maxlength' => 65535,'maxlength' => 65535]) !!}
    </div>
</div> --}}

<!-- Is Ad Import Field -->
{{-- <div id="div-is_ad_import" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_ad_import">Is Ad Import</label>
    <div class="col-sm-9">
        <div class="form-check">
            {!! Form::hidden('is_ad_import', 0, ['class' => 'form-check-input']) !!}
            {!! Form::checkbox('is_ad_import', '1', null, ['class' => 'form-check-input']) !!}
        </div>
    </div>
</div> --}}

<!-- Ad Type Field -->
{{-- <div id="div-ad_type" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="ad_type">Ad Type</label>
    <div class="col-sm-9">
        {!! Form::text('ad_type', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div> --}}

<!-- Ad Key Field -->
{{-- <div id="div-ad_key" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="ad_key">Ad Key</label>
    <div class="col-sm-9">
        {!! Form::text('ad_key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
    </div>
</div> --}}

<!-- Ad Data Field -->
{{-- <div id="div-ad_data" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="ad_data">Ad Data</label>
    <div class="col-sm-9">
        {!! Form::textarea('ad_data', null, ['class' => 'form-control']) !!}
    </div>
</div> --}}

<!-- Parent Id Field -->
{{-- <div id="div-parent_id" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="parent_id">Parent Id</label>
    <div class="col-sm-9">
        {!! Form::text('parent_id', null, ['class' => 'form-control','maxlength' => 36,'maxlength' => 36]) !!}
    </div>
</div> --}}

<!-- Organization Id Field -->
{{-- <div id="div-organization_id" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="organization_id">Organization Id</label>
    <div class="col-sm-9">
        {!! Form::text('organization_id', null, ['class' => 'form-control','maxlength' => 36,'maxlength' => 36]) !!}
    </div>
</div> --}}
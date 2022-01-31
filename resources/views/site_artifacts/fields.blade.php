<!-- Headline Field -->
<div id="div-headline" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="headline">Headline</label>
    <div class="col-sm-9">
        {!! Form::text('headline', null, ['class' => 'form-control','minlength' => 0,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Type Field -->
<div id="div-type" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="type">Type</label>
    <div class="col-sm-9">
        {!! Form::text('type', null, ['class' => 'form-control','minlength' => 0,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Content Field -->
<div id="div-content" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="content">Content</label>
    <div class="col-sm-9">
        {!! Form::text('content', null, ['class' => 'form-control','minlength' => 0,'maxlength' => 2000]) !!}
    </div>
</div>

<!-- Is Sticky Field -->
<div id="div-is_sticky" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_sticky">Is Sticky</label>
    <div class="col-sm-9">
        {!! Form::text('is_sticky', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Is Flashing Field -->
<div id="div-is_flashing" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_flashing">Is Flashing</label>
    <div class="col-sm-9">
        {!! Form::text('is_flashing', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Is External Url Field -->
<div id="div-is_external_url" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="is_external_url">Is External Url</label>
    <div class="col-sm-9">
        {!! Form::text('is_external_url', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Display Start Date Field -->
<div id="div-display_start_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="display_start_date">Display Start Date</label>
    <div class="col-sm-4">
        {!! Form::text('display_start_date', null, ['class' => 'form-control','id'=>'display_start_date']) !!}
    </div>
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#display_start_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Display End Date Field -->
<div id="div-display_end_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="display_end_date">Display End Date</label>
    <div class="col-sm-4">
        {!! Form::text('display_end_date', null, ['class' => 'form-control','id'=>'display_end_date']) !!}
    </div>
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#display_end_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Specific Display Date Field -->
<div id="div-specific_display_date" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="specific_display_date">Specific Display Date</label>
    <div class="col-sm-4">
        {!! Form::text('specific_display_date', null, ['class' => 'form-control','id'=>'specific_display_date']) !!}
    </div>
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#specific_display_date').datetimepicker({
            //format: 'YYYY-MM-DD HH:mm:ss',
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush
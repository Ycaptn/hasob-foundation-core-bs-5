<!-- Label Field -->
<div id="div_announcement_headline" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('label', 'Label:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_headline">
        @if (isset($announcement->headline) && empty($announcement->headline)==false)
            {!! $announcement->headline !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Contact Person Field -->
<div id="div_announcement_content" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('content', 'Contact Person:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_content">
        @if (isset($announcement->content) && empty($announcement->content)==false)
            {!! $announcement->content !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- start_date Field -->
<div id="div_announcement_start_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('start_date', 'start_date:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_start_date">
        @if (isset($announcement->start_date) && empty($announcement->start_date)==false)
            {!! $announcement->start_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- end_date Field -->
<div id="div_announcement_end_date" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('end_date', 'end_date:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_end_date">
        @if (isset($announcement->end_date) && empty($announcement->end_date)==false)
            {!! $announcement->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>






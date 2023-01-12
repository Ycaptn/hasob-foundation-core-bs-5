<!-- Label Field -->
<div id="div_announcement_headline" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('headline', 'Headline:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_headline">
        @if (isset($announcement->headline) && empty($announcement->headline)==false)
            {!! $announcement->headline !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Content Field -->
<div id="div_announcement_content" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('content', 'Content:', ['class'=>'control-label']) !!} 
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
        {!! Form::label('start_date', 'Start Date:', ['class'=>'control-label']) !!} 
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
        {!! Form::label('end_date', 'End Date:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_end_date">
        @if (isset($announcement->end_date) && empty($announcement->end_date)==false)
            {!! $announcement->end_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- is_sticky Field -->
<div id="div_announcement_is_sticky" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('is_sticky', 'Is Sticky:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_is_sticky">
        @if (isset($announcement->is_sticky) && empty($announcement->is_sticky)==false)
            Yes
        @else
           No
        @endif
        </span>
    </p>
</div>

<!-- is_flashing Field -->
<div id="div_announcement_is_flashing" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('is_flashing', 'Is Flashing:', ['class'=>'control-label']) !!} 
        <span id="spn_announcement_is_flashing">
        @if (isset($announcement->is_flashing) && empty($announcement->is_flashing)==false)
            Yes
        @else
           No
        @endif
        </span>
    </p>
</div>






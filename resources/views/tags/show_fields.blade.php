<!-- Parent Id Field -->
<div id="div_tag_parent_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('parent_id', 'Parent Id:', ['class'=>'control-label']) !!} 
        <span id="spn_tag_parent_id">
        @if (isset($tag->parent_id) && empty($tag->parent_id)==false)
            {!! $tag->parent_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Name Field -->
<div id="div_tag_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_tag_name">
        @if (isset($tag->name) && empty($tag->name)==false)
            {!! $tag->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Meta Data Field -->
<div id="div_tag_meta_data" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('meta_data', 'Meta Data:', ['class'=>'control-label']) !!} 
        <span id="spn_tag_meta_data">
        @if (isset($tag->meta_data) && empty($tag->meta_data)==false)
            {!! $tag->meta_data !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


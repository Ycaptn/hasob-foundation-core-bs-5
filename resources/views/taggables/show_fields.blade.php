<!-- Taggable Id Field -->
<div id="div_taggable_taggable_id" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('taggable_id', 'Taggable Id:', ['class'=>'control-label']) !!} 
        <span id="spn_taggable_taggable_id">
        @if (isset($taggable->taggable_id) && empty($taggable->taggable_id)==false)
            {!! $taggable->taggable_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


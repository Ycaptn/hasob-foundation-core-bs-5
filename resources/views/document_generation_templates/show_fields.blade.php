<!-- Title Field -->
<div id="div_documentGenerationTemplate_title" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('title', 'Title:', ['class'=>'control-label']) !!} 
        <span id="spn_documentGenerationTemplate_title">
        @if (isset($documentGenerationTemplate->title) && empty($documentGenerationTemplate->title)==false)
            {!! $documentGenerationTemplate->title !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Content Field -->
<div id="div_documentGenerationTemplate_content" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('content', 'Content:', ['class'=>'control-label']) !!} 
        <span id="spn_documentGenerationTemplate_content">
        @if (isset($documentGenerationTemplate->content) && empty($documentGenerationTemplate->content)==false)
            {!! $documentGenerationTemplate->content !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


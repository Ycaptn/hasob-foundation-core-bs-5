{{-- <!-- Name Field -->
<div id="div_batch_name" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('name', 'Name:', ['class'=>'control-label']) !!} 
        <span id="spn_batch_name">
        @if (isset($batch->name) && empty($batch->name) == false)
            {!! $batch->name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div> --}}
<!-- Batchable Type Field -->
{{-- <div id="div_batchable_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('batchable_type', 'Batching Type:', ['class'=>'control-label']) !!} 
        <span id="spn_batchable_type">
        @if (isset($batch->batchable_type) && empty($batch->batchable_type) == false)
            {!! $batch->batchable_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>
 --}}
<!-- Workable Type Field -->
@php
    $batch_memos = [];
    
    $is_memorable = $batch->is_memorable();
    
@endphp
<div id="div_workable_type" class="col-sm-12 mb-10">
    <p>
        {!! Form::label('workable_type', 'Processing Type:', ['class' => 'control-label']) !!}
        <span id="spn_workable_type">
            @if (isset($batch->workable_type) && empty($batch->workable_type) == false)
                @php
                    $parts = explode('\\', $batch->workable_type);
                    echo array_pop($parts);
                @endphp
            @else
                N/A
            @endif
        </span>
        @if ($is_memorable)
            <x-hasob-edms-engine::memorable-memo-creator :memorable="$batch" />
        @endif
    </p>
</div>

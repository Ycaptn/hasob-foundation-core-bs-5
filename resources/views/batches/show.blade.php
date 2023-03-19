@extends('layouts.app')

@section('title_postfix')
    Batch Details
@stop

@section('page_title')
    Batch Details
@stop

@section('page_title_subtext')
    <a class="ms-10 mb-10" href="{{ route('fc.batches.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Batch List
    </a>
@stop

@section('page_title_buttons')
    <span class="float-end">
        <div class="float-end inline-block dropdown mb-15">
            <a href="#" data-val='{{ $batch->id }}' class='btn btn-xs btn-primary btn-edit-mdl-batch-modal'>
                <i class="icon wb-reply" aria-hidden="true"></i>Edit Batch
            </a>
        </div>
    </span>
@stop

@section('content')
    <div class="card  border-top border-0 border-4 border-success">

        <div class="card-body">
            <div class="form-wrap">
                <div class="row">
                    @include('hasob-foundation-core::batches.show_fields')
                </div>
                @if (\FoundationCore::has_feature('workflow', $organization) && $batch->workable_type != null)
                    @php
                        $worklow_name = null;
                        $workable_object = null;
                        $title = $batch->name;
                        $workflow_object = \Hasob\Workflow\Models\Workflow::where('workable_type', $batch->workable_type)->first();
                        
                        if ($workflow_object != null) {
                            $workflow_name = $workflow_object->name;
                        }
                    @endphp
                    @if (!empty($workflow_name))
                        <button class="btn float-end btn-danger btn_process_batch"
                            data-val-workable-type="{{ $batch->workable_type }}"
                            data-val-workable-id="{{ $batch->id }}">Process Batch</button>
                        <x-hasob-workflow-engine::workflow-invoker :target="'btn-process-batch'" :workflow="$workflow_name" :workable="$workable_object"
                            :origin_department_only="Auth()
                                ->user()
                                ->hasRole('admin') == false" :roles="null" :users="null" :departments="null" :title="'New Batch Processing'"
                            :targetClass="'btn_process_batch'" />
                    @endif

                @endif
            </div>
        </div>

    </div>
@endsection
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-save-work-invocation').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });


                //check for internet status 
                if (!window.navigator.onLine) {
                    $('.offline').fadeIn(300);
                    return;
                } else {
                    $('.offline').fadeOut(300);
                }

                let actionType = "PUT";
                let endPointUrl =  endPointUrl = "{{ route('fc-api.batches.update', $batch->id) }}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('id', "{{$batch->id}}");         
                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                // formData.append('', $('#').val());
                formData.append('name', "{{$batch->name}}");       
                formData.append('batchable_type', "{{$batch->batchable_type}}");  
                formData.append('status', "processing");          
                formData.append('workable_type', "{{$batch->workable_type}}");
               
                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                       
                    },
                    error: function(data) {
                        console.log(data);
                     
                    }
                });
            });
        })

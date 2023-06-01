@extends('layouts.app')

@section('title_postfix')
    Batch Details
@stop

@section('page_title')
    {{--   Batch Details --}}
    {{ $batch->name }} Details
@stop

@section('page_title_subtext')
    <a class="ms-10 mb-10" href="{{ route('fc.batches.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Batch List
    </a>
@stop

@section('page_title_suffix')
    @php
        $parts = explode('\\', $batch->batchable_type);
        echo array_pop($parts);
    @endphp
@stop

@section('page_title_buttons')
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
        @if (!empty($workflow_name) && $batch->status == 'new')
            <button class="btn btn-sm btn-danger btn_process_batch mx-2" data-val-workable-type="{{ $batch->workable_type }}"
                data-val-workable-id="{{ $batch->id }}">Process Batch</button>
            <x-hasob-workflow-engine::workflow-invoker :target="'btn-process-batch'" :workflow="$workflow_name" :workable="$workable_object"
                :origin_department_only="Auth()
                    ->user()
                    ->hasRole('admin') == false" :roles="null" :users="null" :departments="null" :title="'New Batch Processing'"
                :targetClass="'btn_process_batch'" />
        @endif

    @endif
    <span class="float-end">
        <div class="float-end inline-block dropdown mb-15">
            <a href="#" data-val='{{ $batch->id }}' class='btn btn-sm btn-warning btn-edit-mdl-batch-modal'>
                <i class="icon wb-reply" aria-hidden="true"></i>Edit Batch
            </a>
        </div>
    </span>

    <span class="float-end">
        <div class="float-end inline-block dropdown mx-2">
            <a href="#" data-val='{{ $batch->id }}' class='btn btn-sm btn-primary btn-preview-mdl-batch-modal'>
                <i class="icon wb-reply" aria-hidden="true"></i> Preview Batch Items
            </a>
        </div>
    </span>
@stop
@php
    $batch_preview = $batch->getBatchPreview();
    $movable_batches = $batch->getMovableBatches();
@endphp
@section('content')
    <div class="card  border-top border-0 border-4 border-success">

        <div class="card-body">
            <div class="form-wrap">
                <div class="row">
                    @include('hasob-foundation-core::batches.show_fields')
                </div>
            </div>
            <ul class="nav nav-tabs nav-primary" role="tablist" id="tab_batch">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_batched_items" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-pie-chart font-18 me-1"></i></div>
                            <div class="tab-title">Items in Batch</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_batchable_items" role="tab"
                        aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-purchase-tag-alt font-18 me-1"></i></div>
                            <div class="tab-title">Items not in Batch</div>
                        </div>
                    </a>
                </li>
              
            </ul>
            <div class="tab-content py-3">
                <div class="tab-pane fade show active" id="tab_batched_items" role="tabpanel">
                    @include('hasob-foundation-core::batches.partials.batched-items')
                </div>
                <div class="tab-pane fade" id="tab_batchable_items" role="tabpanel">
                    @include('hasob-foundation-core::batches.partials.batchable-items')
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="mdl-preview-batch-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="lbl-batch-preview-modal-title" class="modal-title">Batch Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $batch_preview !!}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>
    @include('hasob-foundation-core::batches.modal')
@endsection
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', ".btn-preview-mdl-batch-modal", function(e) {
                $('#mdl-preview-batch-modal').modal('show');

            });

            $('.btn-save-work-invocation').click(function(e) {
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
                let endPointUrl = "{{ route('fc-api.batches.update', $batch->id) }}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('id', "{{ $batch->id }}");
                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                // formData.append('', $('#').val());
                formData.append('name', "{{ $batch->name }}");
                formData.append('batchable_type', "{{ $batch->batchable_type }}");
                formData.append('status', "processing");
                formData.append('workable_type', "{{ $batch->workable_type }}");

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
    </script>
@endpush

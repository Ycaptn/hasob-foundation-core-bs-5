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
@php
    $batch_preview = $batch->getBatchPreview();
@endphp
@section('content')
    <div class="card  border-top border-0 border-4 border-success">

        <div class="card-body">
            <div class="form-wrap">
                <div class="row">
                    @include('hasob-foundation-core::batches.show_fields')
                </div>
                <div class="float-end">
                    <button class="btn btn-primary btn-add-batch-items mx-2">Add Batch Items</button>
                    <button class="btn btn-warning btn-remove-batch-items mx-2">Remove Batch Items</button>
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
                            <button class="btn btn-danger btn_process_batch"
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

    </div>

    <div class="modal fade" id="mdl-batch-item-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="lbl-batch-item-modal-title" class="modal-title">Batch Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-batch-item-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-batch-item-modal" role="form" method="POST"
                        enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">

                                @csrf

                                <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                                <div id="spinner-batch-items" class="">
                                    <div class="loader" id="loader-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        {!! $batch_preview !!}
                                    </div>
                                    <div class="col-md-4">
                                        <select name="sel_batchable_id" id="sel_batchable_id" class="form-select">
                                            <option value="">-- Select Batch Item--</option>
                                            @foreach ($batchable_items as $batchable_item)
                                                <option value="{{ $batchable_item['value'] }}"> {{ $batchable_item['key'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="div-add-mdl-batch-item-modal" class="modal-footer">
                                            <hr class="light-grey-hr mb-10" />
                                            <button class="btn-save-add-batch-item btn btn-primary my-2">
                                                <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                <span class="visually-hidden">Loading...</span>
                                                Save Added Batch Item
                                            </button>
                                        </div>
                                       

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                

            </div>
        </div>
    </div>

    <div class="modal fade" id="mdl-remove-batch-item-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="lbl-remove-batch-item-modal-title" class="modal-title">Remove Batch Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-remove-batch-item-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-remove-batch-item-modal" role="form" method="POST"
                        enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">

                                @csrf

                                <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                                <div id="spinner-remove-batch-items" class="">
                                    <div class="loader" id="loader-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        {!! $batch_preview !!}
                                    </div>
                                    <div class="col-md-4">
                                        <select name="sel_batchable_id" id="sel_batched_id" class="form-select">
                                            <option value="">-- Select Batch Item--</option>
                                            @foreach ($batched_items as $batched_item)
                                                <option value="{{ $batched_item['value'] }}"> {{ $batched_item['key'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="div-add-mdl-remove-batch-item-modal" class="modal-footer">
                                            <hr class="light-grey-hr mb-10" />
                                            <button class="btn-save-remove-batch-item btn btn-primary my-2">
                                                <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                <span class="visually-hidden">Loading...</span>
                                                Remove Added Batch Item
                                            </button>
                                        </div>
                                       

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                

            </div>
        </div>
    </div>

@endsection
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            //Show Modal for New Entry
            $(document).on('click', ".btn-add-batch-items", function(e) {
                $('#div-batch-item-modal-error').hide();
                $('#mdl-batch-item-modal').modal('show');
                $('#frm-batch-item-modal').trigger("reset");
                $('#btn-add-mdl-batch-item-modal span').hide()
                $('.btn-save-add-batch-item span').hide()
                $('.btn-save-add-batch-item').attr('disabled',false)
                $("#spinner-batch-items").hide();
                $('.offline').fadeOut(300);
                $("#div-add-mdl-batch-item-modal").attr('disabled', false);
            });

            $(document).on('click', ".btn-remove-batch-items", function(e) {
                $('#div-remove-batch-item-modal-error').hide();
                $('#mdl-remove-batch-item-modal').modal('show');
                $('#frm-remove-batch-item-modal').trigger("reset");
                $('.btn-save-remove-batch-item span').hide()
                $('.btn-save-remove-batch-item').attr('disabled',false)
                $("#spinner-remove-batch-items").hide();
                $('.offline').fadeOut(300);
                
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
                formData.append('batchable_type', "{{$batch->batchable_type }}");
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

            $('.btn-save-add-batch-item').click(function(e) {
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
                $('.btn-save-add-batch-item span').show()
                $('.btn-save-remove-batch-item').attr('disabled',true)

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.batch_items.store') }}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('batch_id', "{{ $batch->id }}");
                formData.append('batchable_type', String.raw`{{ $batch->batchable_type }}`);
                formData.append('batchable_id', $('#sel_batchable_id').val());
                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif

                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            $('#div-batch-item-modal-error').html('');
                            $('#div-batch-item-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-batch-item-modal-error').append(
                                    '<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            $('#div-batch-item-modal-error').hide();
                            window.setTimeout(function() {

                                $('#div-batch-item-modal-error').hide();

                                swal({
                                    title: "Saved",
                                    text: "Batch item added successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                }, function() {
                                    location.reload(true);
                                });

                            }, 20);
                        }
                        $('.btn-save-add-batch-item').attr('disabled',false)
                        $('.btn-save-add-batch-item span').hide()
                    },
                    error: function(data) {
                        console.log(data);
                        $('.btn-save-add-batch-item span').hide()
                        $('.btn-save-add-batch-item').attr('disabled',false)
                    }
                });
            });

            $('.btn-save-remove-batch-item').click(function(e) {
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
                $('.btn-save-remove-batch-item span').show()
                $('.btn-save-remove-batch-item').attr('disabled',true)
                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.batch.remove-batch-item',$batch->id) }}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('batch_id', "{{ $batch->id }}");
                formData.append('batchable_type', String.raw`{{ $batch->batchable_type }}`);
                formData.append('batchable_id', $('#sel_batched_id').val());
                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif

                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            $('#div-remove-batch-item-modal-error').html('');
                            $('#div-remove-batch-item-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-remove-batch-item-modal-error').append(
                                    '<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            $('#div-remove-batch-item-modal-error').hide();
                            window.setTimeout(function() {

                                $('#div-remove-batch-item-modal-error').hide();

                                swal({
                                    title: "Saved",
                                    text: "Batch item removed added successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                }, function() {
                                    location.reload(true);
                                });

                            }, 20);
                        }

                        $('.btn-save-remove-batch-item span').hide()
                        $('.btn-save-remove-batch-item').attr('disabled',false)
                    },
                    error: function(data) {
                        console.log(data);
                        $('.btn-save-remove-batch-item').attr('disabled',false)
                        $('.btn-save-remove-batch-item span').hide()
                    }
                });
            });
        })
    </script>
@endpush

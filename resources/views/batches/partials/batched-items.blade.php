<div>
    <div class="row">
        @if (count($batched_items) > 0)
       
            @if ($batch->status != 'processed')    
                <div class="col-sm-6">
                    <strong>Items inside batch</strong> 
                </div>
                <div class="col-sm-6 mb-4">
                    <button class="btn btn-warning float-end btn-sm btn-save-remove-batch-item mx-2">Remove Selections</button>
                    <button class="btn btn-danger float-end btn-sm btn-mdl-batch-move-modal">Move Selections</button>
                </div>

            @endif
            <div id="div-remove-batch-item-modal-error" class="alert alert-danger" role="alert"></div>
            @foreach ($batched_items as $batched_item)
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $batched_item['value'] }}"
                            name="cbx_batched_items" id="{{ $batched_item['value'] }}-cbx_batched_items">
                        <label class="form-check-label" for="{{ $batched_item['value'] }}-cbx_batched_items">
                            {{ $batched_item['key'] }}
                        </label>
                    </div>
                </div>
            @endforeach
        @else
            <span class="my-3">No Item inside batch</span>
        @endif
    </div>
</div>

<div class="modal fade" id="mdl-batch-move-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-batch-move-modal-title" class="modal-title">Batch Move Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-batch-move-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-batch-move-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">

                            @csrf

                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-batch-move" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="control-label mb-10 col-sm-12">Batches</label>
                                    <select name="move_to_batch" id="move_to_batch" class="form-select">
                                        <option value="">
                                            --select batch to move selected items --
                                        </option>
                                        @foreach ($movable_batches as $movable_batch)
                                            <option value="{{ $movable_batch->id }}"> {{ $movable_batch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-batch-move-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-batch-move-modal" value="add">
                    <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Loading...</span>
                    Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div-remove-batch-item-modal-error').hide();

            $(document).on('click', ".btn-mdl-batch-move-modal", function(e) {
                let selected_ids = [];
                $("input[name='cbx_batched_items']:checked").each(function(item) {
                    selected_ids.push($(this).val());
                });

                if (selected_ids.length === 0) {

                    swal({
                        title: "Warning",
                        text: "No Batch Item Selected for Moving",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {

                    });

                } else {
                    $('#div-batch-move-modal-error').hide();
                    $('#mdl-batch-move-modal').modal('show');
                    $('#frm-batch-move-modal').trigger("reset");
                    $('#btn-save-mdl-batch-move-modal span').hide()
                    $("#spinner-batches-move").hide();
                    $("#div-save-mdl-batch-modal").attr('disabled', false);
                }

            });

            $('.btn-save-remove-batch-item').click(function(e) {
                e.preventDefault();

                let selected_ids = [];
                $("input[name='cbx_batched_items']:checked").each(function(item) {
                    selected_ids.push($(this).val());
                });

                if (selected_ids.length === 0) {

                    swal({
                        title: "Warning",
                        text: "No Batch Item Selected for Removal",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {

                    });

                } else {


                    swal({
                        title: "Are you sure you want to remove the selected items to this this batch?",
                        text: "The selected batch items is can still be re-added when removed",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            swal({
                                title: '<div id="spinner-remove-batchable-items" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Loading...  </span> </div> <br><br>Deleting...',
                                text: 'Please wait while selected is been removed from batch.<br><br> Do not refresh this page! ',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                html: true
                            });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });
                            $('.btn-save-remove-batch-item span').show()
                            $('.btn-save-remove-batch-item').attr('disabled', true)
                            let actionType = "POST";
                            let endPointUrl =
                                "{{ route('fc-api.batch.remove-batch-item', $batch->id) }}";
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('batch_id', "{{ $batch->id }}");
                            formData.append('batchable_type', String
                                .raw`{{ $batch->batchable_type }}`);
                            formData.append("batchable_id", selected_ids);
                            // formData.append('batchable_id', $('#sel_batched_id').val());
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
                                        $('#div-remove-batch-item-modal-error').html(
                                            '');
                                        $('#div-remove-batch-item-modal-error').show();

                                        $.each(result.errors, function(key, value) {
                                            $('#div-remove-batch-item-modal-error')
                                                .append(
                                                    '<li class="">' +
                                                    value + '</li>');
                                        });
                                    } else {
                                        $('#div-remove-batch-item-modal-error').hide();
                                        window.setTimeout(function() {

                                            $('#div-remove-batch-item-modal-error')
                                                .hide();

                                            swal({
                                                title: "Saved",
                                                text: "Batch items removed successfully",
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
                                    $('.btn-save-remove-batch-item').attr('disabled',
                                        false)
                                },
                                error: function(data) {
                                    console.log(data);
                                    $('.btn-save-remove-batch-item').attr('disabled',
                                        false)
                                    $('.btn-save-remove-batch-item span').hide()
                                }
                            });
                        }
                    });

                }

            })

            $('#btn-save-mdl-batch-move-modal').click(function(e) {
                e.preventDefault();

                let selected_ids = [];
                $("input[name='cbx_batched_items']:checked").each(function(item) {
                    selected_ids.push($(this).val());
                });

                if (selected_ids.length === 0) {

                    swal({
                        title: "Warning",
                        text: "No Batch Item Selected for Moving",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {

                    });

                } else {


                    swal({
                        title: "Are you sure you want to move the selected items to this batch?",
                        text: "This will be the selected items to the new batch selected",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            swal({
                                title: '<div id="spinner-move-batchable-items" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Loading...  </span> </div> <br><br>Moving...',
                                text: 'Please wait while selected is been added to batch.<br><br> Do not refresh this page! ',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                html: true
                            });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });
                            $('.btn-save-mdl-batch-move-modal span').show()
                            $('.btn-save-mdl-batch-move-modal').attr('disabled', true)
                            let actionType = "POST";
                            let endPointUrl =
                                "{{ route('fc-api.batch.move-batch-item', $batch->id) }}";
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('batch_id', "{{ $batch->id }}");
                            formData.append('batchable_type', String
                                .raw`{{ $batch->batchable_type }}`);
                            formData.append("batchable_id", selected_ids);
                            formData.append("move_to_batch_id", $('#move_to_batch').val());
                            // formData.append('batchable_id', $('#sel_batched_id').val());
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
                                        $('#div-move-batch-item-modal-error').html(
                                            '');
                                        $('#div-move-batch-item-modal-error').show();

                                        $.each(result.errors, function(key, value) {
                                            $('#div-move-batch-item-modal-error')
                                                .append(
                                                    '<li class="">' +
                                                    value + '</li>');
                                        });
                                    } else {
                                        $('#div-remove-batch-item-modal-error').hide();
                                        window.setTimeout(function() {

                                            $('#div-move-batch-item-modal-error')
                                                .hide();

                                            swal({
                                                title: "Saved",
                                                text: "Batch items moved added successfully",
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

                                    $('.btn-save-mdl-batch-move-modal span').hide()
                                    $('.btn-save-mdl-batch-move-modal').attr('disabled',
                                        false)
                                },
                                error: function(data) {
                                    console.log(data);
                                    $('.btn-save-mdl-batch-move-modal').attr('disabled',
                                        false)
                                    $('.btn-save-mdl-batch-move-modal span').hide()
                                }
                            });
                        }
                    });

                }

            })



        })
    </script>
@endpush

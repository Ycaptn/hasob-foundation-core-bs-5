<div class="modal fade" id="mdl-batch-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-batch-modal-title" class="modal-title">Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-batch-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-batch-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">

                            @csrf

                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-batches" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-batch-primary-id" value="0" />
                            <div id="div-show-txt-batch-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                        @include('hasob-foundation-core::batches.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-batch-primary-id">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @include('hasob-foundation-core::batches.fields')
                                    </div>
                                    <div class="col-lg-4">
                                        <div id="div-batchable-type" class="form-group">
                                            <label class="col-lg-12 small col-form-label fw-bold">Applies to</label>
                                            @foreach (\FoundationCore::get_batchable_models($organization) as $idx => $model)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        value="{{ $model->value }}" name="cbx-batchable-type">
                                                    <label class="form-check-label">{{ $model->key }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-batch-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-batch-modal" value="add">
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

            $('.offline').hide();

            //Show Modal for New Entry
            $(document).on('click', ".btn-new-mdl-batch-modal", function(e) {
                $('#div-batch-modal-error').hide();
                $('#mdl-batch-modal').modal('show');
                $('#frm-batch-modal').trigger("reset");
                $('#txt-batch-primary-id').val(0);
                $('#btn-save-mdl-batch-modal span').hide()
                $('#div-show-txt-batch-primary-id').hide();
                $('#div-edit-txt-batch-primary-id').show();

                $("#spinner-batches").hide();
                $("#div-save-mdl-batch-modal").attr('disabled', false);
            });

            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-batch-modal", function(e) {
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

                $('#div-batch-modal-error').hide();
                $('#mdl-batch-modal').modal('show');
                $('#frm-batch-modal').trigger("reset");

                $("#spinner-batches").show();
                $("#div-save-mdl-batch-modal").attr('disabled', true);
                $('#btn-save-mdl-batch-modal span').hide()
                $('#div-show-txt-batch-primary-id').show();
                $('#div-edit-txt-batch-primary-id').hide();
                let itemId = $(this).attr('data-val');

                $.get("{{ route('fc-api.batches.show', '') }}/" + itemId).done(function(response) {

                    $('#txt-batch-primary-id').val(response.data.id);
                    $('#spn_batch_name').html(response.data.name);


                    $("#spinner-batches").hide();
                    $("#div-save-mdl-batch-modal").attr('disabled', false);
                });
            });

            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-batch-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-batch-modal-error').hide();
                $('#mdl-batch-modal').modal('show');
                $('#frm-batch-modal').trigger("reset");

                $("#spinner-batches").show();
                $("#div-save-mdl-batch-modal").attr('disabled', true);

                $('#div-show-txt-batch-primary-id').hide();
                $('#div-edit-txt-batch-primary-id').show();
                $('#btn-save-mdl-batch-modal span').hide()
                let itemId = $(this).attr('data-val');

                $.get("{{ route('fc-api.batches.show', '') }}/" + itemId).done(function(response) {

                    $('#txt-batch-primary-id').val(response.data.id);
                    $('#name').val(response.data.name);
                    $('input[name="cbx-batchable-type"]').each(function() {
                        if (response.data.batchable_type.includes(this.value.split("\\")
                            .pop())) {
                            $(this).prop('checked', 'checked');
                        }
                    });

                    $('#sel_workable_type').val(response.data.workable_type)

                    $('#btn-save-mdl-batch-modal span').hide()
                    /*  $("#spinner-batches").hide(); */
                    $("#div-save-mdl-batch-modal").attr('disabled', false);
                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-batch-modal", function(e) {
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

                let itemId = $(this).attr('data-val');
                swal({
                    title: "Are you sure you want to delete this Batch?",
                    text: "You will not be able to recover this Batch if deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {

                        let endPointUrl = "{{ route('fc-api.batches.destroy', '') }}/" + itemId;

                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('_method', 'DELETE');

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
                                    console.log(result.errors)
                                    swal("Error",
                                        "Oops an error occurred. Please try again.",
                                        "error");
                                } else {
                                    //swal("Deleted", "Batch deleted successfully.", "success");
                                    swal({
                                        title: "Deleted",
                                        text: "Batch deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    }, function() {
                                        location.reload(true);
                                    });
                                }
                            },
                        });
                    }
                });

            });

            //Save details
            $('#btn-save-mdl-batch-modal').click(function(e) {
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

                $("#spinner-batches").show();
                $("#div-save-mdl-batch-modal").attr('disabled', true);

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.batches.store') }}";
                let primaryId = $('#txt-batch-primary-id').val();
                $('#btn-save-mdl-batch-modal span').show()
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId != "0") {
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc-api.batches.update', '') }}/" + primaryId;
                    formData.append('id', primaryId);
                }else{
                    formData.append('status', "new");
                }

                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                // formData.append('', $('#').val());
                formData.append('name', $('#name').val());
                if ($('input[name="cbx-batchable-type"]').is(':checked')) {
                    formData.append('batchable_type', $('input[name="cbx-batchable-type"]:checked').val());
                } else {
                    formData.append('batchable_type', "");
                }
                formData.append('workable_type', $('#sel_workable_type').val());
                formData.append('creator_user_id', "{{ auth()->user()->id }}");
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
                            $('#div-batch-modal-error').html('');
                            $('#div-batch-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-batch-modal-error').append('<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            $('#div-batch-modal-error').hide();
                            window.setTimeout(function() {

                                $('#div-batch-modal-error').hide();

                                swal({
                                    title: "Saved",
                                    text: "Batch saved successfully",
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

                        $("#spinner-batches").hide();
                        $("#div-save-mdl-batch-modal").attr('disabled', false);
                        $('#btn-save-mdl-batch-modal span').hide()
                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");
                        $('#btn-save-mdl-batch-modal span').hide()
                        $("#spinner-batches").hide();
                        $("#div-save-mdl-batch-modal").attr('disabled', false);

                    }
                });
            });

        });
    </script>
@endpush

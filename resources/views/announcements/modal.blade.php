<div class="modal fade" id="mdl-announcement-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
              
                <h4 id="lbl-announcement-modal-title" class="modal-title">Announcement</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-announcement-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-announcement-modal" role="form" method="POST"
                    enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">

                            @csrf

                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-announcements" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-announcement-primary-id" value="0" />
                            <div id="div-show-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-11 ma-10">
                                        @include('hasob-foundation-core::announcements.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-announcement-primary-id">
                                <div class="row">
                                    <div class="col-lg-11 ma-10">
                                        @include('hasob-foundation-core::announcements.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-announcement-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-announcement-modal"
                    value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.offline').hide();

            //Show Modal for New Entry
            $(document).on('click', ".btn-new-mdl-announcement-modal", function(e) {
                $('#div-announcement-modal-error').hide();
                $('#mdl-announcement-modal').modal('show');
                $('#frm-announcement-modal').trigger("reset");
                $('#txt-announcement-primary-id').val(0);

                $('#div-show-txt-announcement-primary-id').hide();
                $('#div-edit-txt-announcement-primary-id').show();

                $("#spinner-announcements").hide();
                $("#div-save-mdl-announcement-modal").attr('disabled', false);
            });

            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-announcement-modal", function(e) {
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

                $('#div-announcement-modal-error').hide();
                $('#mdl-announcement-modal').modal('show');
                $('#frm-announcement-modal').trigger("reset");

                $("#spinner-announcements").show();
                $("#div-save-mdl-announcement-modal").attr('disabled', true);

                $('#div-show-txt-announcement-primary-id').show();
                $('#div-edit-txt-announcement-primary-id').hide();
                let itemId = $(this).attr('data-val');

                $.get("{{ route('fc-api.announcements.show', '') }}/" + itemId).done(function(response) {

                    $('#txt-announcement-primary-id').val(response.data.id);
                    $('#spn_announcement_label').html(response.data.label);
                    $('#spn_announcement_headline').val(response.data.headline);
                    $('#spn_announcement_content').val(response.data.content);
                    $('#spn_announcement_start_date').val(response.data.start_date);
                    $('#spn_announcement_end_date').val(response.data.end_date);
                    $('#spn_announcement_is_sticky').val(response.data.is_sticky);
                    $('#spn_announcement_is_flashing').val(response.data.is_flashing);


                    $("#spinner-announcements").hide();
                    $("#div-save-mdl-announcement-modal").attr('disabled', false);
                });
            });

            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-announcement-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-announcement-modal-error').hide();
                $('#mdl-announcement-modal').modal('show');
                $('#frm-announcement-modal').trigger("reset");

                $("#spinner-announcements").show();
                $("#div-save-mdl-announcement-modal").attr('disabled', true);

                $('#div-show-txt-announcement-primary-id').hide();
                $('#div-edit-txt-announcement-primary-id').show();
                let itemId = $(this).attr('data-val');

                $.get("{{ route('fc-api.announcements.show', '') }}/" + itemId).done(function(response) {

                    $('#txt-announcement-primary-id').val(response.data.id);
                    $('#headline').val(response.data.headline);
                    $('#content').val(response.data.content);
                    $('#start_date').val(response.data.start_date);
                    $('#end_date').val(response.data.end_date);
                    $('#is_sticky').val(response.data.is_sticky);
                    $('#is_flashing').val(response.data.is_flashing);

                    $("#spinner-announcements").hide();
                    $("#div-save-mdl-announcement-modal").attr('disabled', false);
                });
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-announcement-modal", function(e) {
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
                    title: "Are you sure you want to delete this announcement?",
                    text: "You will not be able to recover this announcement if deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {

                        let endPointUrl = "{{ route('fc-api.announcements.destroy', '') }}/" +
                        itemId;

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
                                    //swal("Deleted", "announcement deleted successfully.", "success");
                                    swal({
                                        title: "Deleted",
                                        text: "announcement deleted successfully",
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
            $('#btn-save-mdl-announcement-modal').click(function(e) {
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

                $("#spinner-announcements").show();
                $("#div-save-mdl-announcement-modal").attr('disabled', true);

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.announcements.store') }}";
                let primaryId = $('#txt-announcement-primary-id').val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId != "0") {
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc-api.announcements.update', '') }}/" + primaryId;
                    formData.append('id', primaryId);
                }

                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                // formData.append('', $('#').val());
                formData.append('headline', $('#headline').val());
                formData.append('content', $('#content').val());
                formData.append('start_date', $('#start_date').val());
                formData.append('end_date',$('#end_date').val());
                formData.append('is_sticky',$('#is_sticky').val());
                formData.append('is_flashing',$('#is_flashing').val())
                formData.append('creator_user_id',"{{auth()->user()->id}}")


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
                            $('#div-announcement-modal-error').html('');
                            $('#div-announcement-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-announcement-modal-error').append(
                                    '<li class="">' + value + '</li>');
                            });
                        } else {
                            $('#div-announcement-modal-error').hide();
                            window.setTimeout(function() {

                                $('#div-announcement-modal-error').hide();

                                swal({
                                    title: "Saved",
                                    text: "announcement saved successfully",
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

                        $("#spinner-announcements").hide();
                        $("#div-save-mdl-announcement-modal").attr('disabled', false);

                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $("#spinner-announcements").hide();
                        $("#div-save-mdl-announcement-modal").attr('disabled', false);

                    }
                });
            });

        });
    </script>
@endpush

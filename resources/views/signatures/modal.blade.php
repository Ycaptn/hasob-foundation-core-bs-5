<div class="modal fade" id="mdl-signatory-item-modal" role="dialog" aria-labelledby="signatory-item-editor-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="lbl-signatory-item-modal-title">Document Signatory Editor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-signatory-item-modal-error" class="alert alert-danger" role="alert"></div>


                <form id="frm-signatory-modal" name="frm_signatory_editor" class="form-horizontal" novalidate=""  enctype="multipart/form-data">
                    @csrf

                    <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                    <input type="hidden" id="txt-signatory-item-primary-id" value="0" />
                    <div id="div-edit-txt-signatory-item-primary-id">

                        <div class="form-group mb-3" id="div-pm_user">
                            <label for="pm_user" class="form-label">Owner</label>
                            <div class="">
                                <div class="form-group">
                                    <select id="pm_user" name="pm_user[]" style="width: 100%">
                                        <option value="">Select a Person</option>
                                        @if (isset($all_users))
                                            @foreach ($all_users as $user)
                                                @if ($user->id!=Auth::id())
                                                
                                                    @if ($user->presence_status=="available")
                                                    <option value="{{$user->id}}">{{ $user->full_name }}  </option>
                                                    @else
                                                    <option value="{{$user->id}}" disabled>{{ $user->full_name }} - {{ ucwords($user->presence_status) }}</option>
                                                    @endif

                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <label for="staff_name" class="col-sm-3 control-label">Signatory Name</label>
                            <input type="text" class="form-control" id="staff_name" name="staff_name" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="staff_title" class="col-sm-3 control-label">Signatory Title</label>
                            <input type="text" class="form-control" id="staff_title" name="staff_title" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="on_behalf" class="col-sm-3 control-label">On Behalf Of</label>
                            <input type="text" class="form-control" id="on_behalf" name="on_behalf" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="current_signatory_image" class="control-label">Current Signature: </label>
                           
                            <img 
                                id="current_signatory_image" 
                                name="current_signatory_image" 
                                width="100px" 
                                height="50px" 
                                src=""/>
                            
                        </div>

                        <div class="form-group mb-3">
                            <label for="signature_image" class="col-sm-3 control-label">Signature File</label>
                            <div class="input-group">
                                <input type='file' class="form-control" name="signature_image" id="signature_image"  />
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="modal-footer" id="div-save-mdl-signatory-item-modal">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-mdl-signatory-item-modal" value="add">
                    <span id="spinner" class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.offline-folders').hide();
            $('#spinner').hide();

            //select2 dropdown
            $("select[id='pm_user']").css('width', '100%');
            $("select[id='pm_user']").select2({
                width: 'resolve'
            });
            $("select[id='pm_user']").select2({
                dropdownParent:$('#mdl-signatory-item-modal')
            });
            


            //previewImage
            const inputImage = document.getElementById('signature_image');
            
            // Add an event listener to the input element to listen for changes
            inputImage.addEventListener("change", function() {
                // Get the selected file
                var file = inputImage.files[0];

                // Create a new FileReader object
                var reader = new FileReader();

                // Set the onload function to handle the file when it's read
                reader.onload = function(event) {
                    // Get the image preview element
                    var imagePreview = document.getElementById("current_signatory_image");

                    // Set the src of the image preview to the data URL of the file
                    imagePreview.src = event.target.result;
                }

                // Read the file as a data URL
                reader.readAsDataURL(file);
            });




            //Show Modal for New Entry
            $(document).on('click', "#btn-new-mdl-signatory-item-modal", function(e) {
                $('#div-signatory-item-modal-error').hide();
                $('#frm-signatory-item-modal').trigger("reset");
                $('#mdl-signatory-item-modal').modal('show');
                $('#txt-signatory-item-primary-id').val(0);
                $('#div-edit-txt-signatory-item-primary-id').show();

                $("#spinner").hide();
                $("#btn-save-mdl-signatory-item-modal").attr('disabled', false);
            });


            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-signatory-item-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $('#div-signatory-item-modal-error').hide();
                $('#mdl-signatory-item-modal').modal('show');
                $('#frm-signatory-item-modal').trigger("reset");

                $("#spinner").show();
                $("#btn-save-mdl-signatory-item-modal").attr('disabled', true);

                $('#div-edit-txt-signatory-item-primary-id').show();
                let itemId = $(this).attr('data-val');

                $.get("{{ route('fc-api.signatures.show', '') }}/" + itemId).done(function(response) {
                    console.log(response)
                    $('#txt-signatory-item-primary-id').val(response.data.id);
                    $('#pm_users').val(response.data.owner_user_id).trigger('change');
                    $('#staff_name').val(response.data.staff_name);
                    $('#staff_title').val(response.data.staff_title);
                    $('#on_behalf').val(response.data.on_behalf);
                    $('#current_signatory_image').attr('src', "{{route('fc.signature.view-item', '')}}/" + itemId);
                    $('#current_signatory_image').show();

                    $("#spinner").hide();
                    $("#btn-save-mdl-signatory-item-modal").attr('disabled', false);
                });

               
            });

            //Delete action
            $(document).on('click', ".btn-delete-mdl-signatory-item-modal", function(e) {
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
                    title: "Are you sure you want to delete this Signatory?",
                    text: "You will not be able to recover this Signatory record if deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {

                        let endPointUrl = "{{ route('fc-api.signatures.destroy', '') }}/" + itemId;

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
                                    //swal("Deleted", "signatory-item deleted successfully.", "success");
                                    swal({
                                        title: "Deleted",
                                        text: "Signature deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    });
                                    window.setTimeout(function() {
                                        location.reload(true);
                                    }, 1000);
                                }
                            },
                        });
                    }
                });

            });

            //Save details
            $('#btn-save-mdl-signatory-item-modal').click(function(e) {
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

                $("#spinner").show();
                $("#btn-save-mdl-signatory-item-modal").prop('disabled', true);

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.signatures.store') }}";
                let primaryId = $('#txt-signatory-item-primary-id').val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId != "0") {
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc-api.signatures.update', '') }}/" + primaryId;
                    formData.append('id', primaryId);
                }            
                formData.append('_method', actionType);
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif

                formData.append('staff_name', $('#staff_name').val());
                formData.append('staff_title', $('#staff_title').val());
                formData.append('on_behalf', $('#on_behalf').val());
                formData.append('owner_user_id', $('#pm_user').val());
                let file = $('#signature_image')
                console.log((file));
                formData.append('signature_image', file[0].files[0]);
                    
                // formData.append('signature_image', $('#signature_image').files[0]);
                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        console.log(result, "result")
                        if (result.errors) {
                            $('#div-signatory-item-modal-error').html('');
                            $('#div-signatory-item-modal-error').show();

                            $.each(result.errors, function(key, value) {
                                $('#div-signatory-item-modal-error').append('<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                            $('#div-signatory-item-modal-error').hide();

                            $('#div-signatory-item-modal-error').hide();

                            swal({
                                title: "Saved",
                                text: "Signature saved successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });
                            // window.setTimeout(function() {
                            //     location.reload(true);
                            // }, 1000);

                        }

                        $("#spinner").hide();
                        $("#btn-save-mdl-signatory-item-modal").attr('disabled', false);

                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $("#spinner").hide();
                        $("#btn-save-mdl-signatory-item-modal").attr('disabled', false);

                    }
                });
            });
        })
    </script>

@endpush

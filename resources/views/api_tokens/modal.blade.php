

<div class="modal fade" id="mdl-api_tokens-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <form class="form-horizontal" id="frm-api_tokens-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                <div class="modal-header">
                    <h5 id="lbl-api_tokens-modal-title" class="modal-title">New API Token</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-api_tokens-modal-error" class="alert alert-danger" role="alert"></div>
                    <div class="col-sm-12">
                        <div class="row">
                            
                            <div class="offline-flag"><span class="offline-api_tokens">You are currently offline</span></div>
                            
                            @csrf
                            <input type="hidden" id="txt-api_tokens-primary-id" value="0" />

                            <div class="col-sm-12 text-danger">
                                <b>NOTE:</b> A new API Authorization Token Will be generated for the selected user.
                                <br><b>Immediately copy</b> and make this available to API Token User.
                            </div>
                            <div class="col-sm-12 form-group mt-3 mb-3">
                                <label for="api-token-user" class="form-label">
                                    <b>Select API Token User:</b>
                                </label>
                                <select class="form-select" id="api-token-user" multiple="multiple">
                                    <option value="">-- None Selected --</option>
                                    @if(isset($org_users) && count($org_users) > 0)
                                        @foreach($org_users as $user)
                                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        
            <div class="modal-footer" id="div-save-mdl-api_tokens-modal">
                 <div id="spinner-api_tokens" class="spinner-border text-primary" role="status"> 
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-primary" id="btn-save-mdl-api_tokens-modal">Generate Token</button>
            </div>

        </div>
    </div>
</div>


@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.offline-api_tokens').hide();

    // applying select2 to state
    $("select[id='api-token-user']").css('width', '100%');
    $("select[id='api-token-user']").select2({
        width: 'resolve',
        tags: false, // disable typing in the input field to add custom values
        maximumSelectionLength: 1, // Allow only one item to be selected
    });

    //Show Modal for New Entry
    $(document).on('click', "#btn-new-api_tokens-modal", function(e) {
        $('#div-api_tokens-modal-error').hide();
        $('#mdl-api_tokens-modal').modal('show');
        $('#frm-api_tokens-modal').trigger("reset");
        $('#txt-api_tokens-primary-id').val(0);

        $("#spinner-api_tokens").hide();
        $("#btn-save-mdl-api_tokens-modal").attr('disabled', false);
    });

    //Revoke & Delete action
    $(document).on('click', ".btn-revoke-trash-api_token-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-api_tokens').fadeIn(300);
            return;
        }else{
            $('.offline-api_tokens').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
            title: "Are you sure you want to revoke & trash this API Token?",
            text: "You will not be able to recover this API Token if confirmed.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, proceed",
            cancelButtonText: "No, don't proceed",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>  Loading...  </span> </div> <br><br>Processing...",
                    text: 'Please wait while API Token is being revoked and trashed.<br><br> Do not refresh this page! ',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    html: true
                });

                let endPointUrl = "{{ route('fc-api.api_tokens.destroy','') }}/"+itemId;

                let formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', $('input[name="_token"]').val());
                
                $.ajax({
                    url:endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result){
                        if(result.errors){
                            console.log(result.errors)
                            swal("Error", "Oops an error occurred. Please try again.", "error");
                        }else{
                            swal({
                                title: "Revoked",
                                text: result.message,
                                type: "success",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            },function(){
                                location.reload(true);
                            });
                        }
                    }, error: function(data){
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");
                    }
                });
            }
        });

    });

    //Save details
    $('#btn-save-mdl-api_tokens-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-api_tokens').fadeIn(300);
            return;
        }else{
            $('.offline-api_tokens').fadeOut(300);
        }

        swal({
            title: "Copy token immediatly, make this available to selected user",
            text: "Do you want to proceed?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, proceed",
            cancelButtonText: "No, don't proceed",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>  Loading...  </span> </div> <br><br>Processing...",
                    text: 'Please wait while API Token is being generated.<br><br> Do not refresh this page! ',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    html: true
                });
                $("#spinner-api_tokens").show();
                $("#btn-save-mdl-api_tokens-modal").attr('disabled', true);

                let primaryId = $('#txt-api_tokens-primary-id').val();
                
                let formData = new FormData();
                formData.append('_method', 'POST');
                formData.append('_token', $('input[name="_token"]').val());
                
                @if (isset($organization) && $organization!=null)
                    formData.append('organization_id', '{{$organization->id}}');
                @endif

                if ($('#api-token-user').length){
                    formData.append('api-token-user',$('#api-token-user').val());
                }

                $.ajax({
                    url: "{{ route('fc-api.api_tokens.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result){
                        if(result.errors){
                            swal.close();
        					$('#div-api_tokens-modal-error').html('');
        					$('#div-api_tokens-modal-error').show();
                            
                            $.each(result.errors, function(key, value){
                                $('#div-api_tokens-modal-error').append('<li class="">'+value+'</li>');
                            });
                        }else{
                            $('#div-api_tokens-modal-error').hide();
                            window.setTimeout( function(){

                                $('#div-api_tokens-modal-error').hide();
                                console.log(result);
                                swal({
                                        title: 'GENERATED',
                                        text: '-- COPY TOKEN --\n'+ result.data.token,
                                        type: "success",
                                    },function(){
                                        location.reload(true);
                                });

                            },20);
                        }

                        $("#spinner-api_tokens").hide();
                        $("#btn-save-mdl-api_tokens-modal").attr('disabled', false);
                        
                    }, error: function(data){
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $("#spinner-api_tokens").hide();
                        $("#btn-save-mdl-api_tokens-modal").attr('disabled', false);

                    }
                });
            }

        });

    });
});
</script>
@endpush

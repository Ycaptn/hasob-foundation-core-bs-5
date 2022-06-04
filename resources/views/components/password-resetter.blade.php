@if (isset($password_user) && $password_user!=null)
    <a  href="#" 
        title="Password Reset" 
        id="btn-{{$control_id}}"
        class="btn-password-reset me-1"
        data-toggle="tooltip" 
        data-val-id="{{$password_user->id}}">
            <i class="fa fa-key text-danger small"></i>
    </a>
@endif



@once

    <div class="modal fade" id="mdl-password-reset-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 id="lbl-password-reset-modal-title" class="modal-title">Password Reset</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-password-reset-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-password-reset-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12">
                                @csrf

                                <div id="spinner-password-reset" class="">
                                    <div class="loader" id="loader-password-reset"></div>
                                </div>


                                <p class="text-danger">Genrate Random PAssword Button</p>

                                <input id="password-reset-user-id" type="hidden" value="0" />

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-lg-12 form-label">Password</label>
                                        <div class="col-lg-12">
                                            <div class="{{ $errors->has('password1') ? ' has-error' : '' }}">
                                                <div class="input-group"> 
                                                    <span class="input-group-text bg-transparent"><i class="bx bxs-lock-open"></i></span>
                                                    <input type="password" class="form-control" id="password1" name="password1"  placeholder="Enter Password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-lg-12 form-label">Confirm Password</label>
                                        <div class="col-lg-12">
                                            <div class="{{ $errors->has('password1_confirmation') ? ' has-error' : '' }}">
                                                <div class="input-group"> 
                                                    <span class="input-group-text bg-transparent"><i class="bx bxs-lock"></i></span>
                                                    <input type="password" class="form-control" id="password1_confirmation" name="password1_confirmation" placeholder="Re-enter Password" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-password-reset-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $(document).on('click', ".btn-password-reset", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});

                let itemId = $(this).attr('data-val-id');
                $('#password-reset-user-id').val(itemId);

                $('#mdl-password-reset-modal').modal('show');
                $('#frm-password-reset-modal').trigger("reset");
            });

            //Save details
            $('#btn-save-mdl-password-reset-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                //implement
                //get user id
                //get new password
                //call endpoint to update user password

                $.ajax({
                    url: endPointUrl,
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            //implement
                        } else {
                            swal({
                                title: "Saved",
                                text: "Password updated successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })

                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


        });
    </script>
    @endpush

@endonce
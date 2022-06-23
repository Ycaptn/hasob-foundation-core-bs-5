@if (isset($password_user) && $password_user!=null)
    <a  href="#" 
        title="Password Reset" 
        id="btn-{{$control_id}}"
        class="btn-password-reset me-2"
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
                    <div id="password_validation_error" class="alert alert-danger alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="close_button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" id="frm-password-reset-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12">
                                @csrf

                                <div id="spinner-password-reset" class="">
                                    <div class="loader" id="loader-password-reset"></div>
                                </div>


                                {{-- <p class="text-danger" id="generate_password">Genrate Random PAssword Button</p> --}}
                                <input type='button' value ='Generate Random Password' class="generate_random_password btn btn-primary btn-sm mb-3">

                                <input id="password-reset-user-id" type="hidden" value="0" />

                                <div class="">
                                    <div class="mb-2 row">
                                        <label class="col-lg-3 form-label">Password</label>
                                        <div class="col-lg-9">
                                            <div class="{{ $errors->has('password1') ? ' has-error' : '' }}">
                                                <div class="input-group"> 
                                                    <span class="input-group-text bg-transparent"><i id="lock" class="bx bxs-lock"></i></span>
                                                    <input type="password" class="form-control" id="password1" name="password1"  placeholder="Enter Password" required/>
                                                        <span class="input-group-text">
                                                            <a href="#" class="toggle_hide_password">
                                                                <i 
                                                                    class="fa fa-eye-slash mb-2 pe-auto bg-transparent" 
                                                                    aria-hidden="true" 
                                                                    id="icon"
                                                                    >
                                                                </i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div id="checkPasswordMatch"></div>
                                    </div>
                                    <div class="mb-2 row">
                                        <label class="col-lg-3 form-label">Confirm Password</label>
                                        <div class="col-lg-9">
                                            <div class="{{ $errors->has('password1_confirmation') ? ' has-error' : '' }}">
                                                <div class="input-group"> 
                                                    <span class="input-group-text bg-transparent">
                                                        <i id="lock" class="bx bxs-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password1_confirmation" name="password1_confirmation" placeholder="Re-enter Password" required/>
                                                     <span class="input-group-text">
                                                            <a href="#" class="toggle_hide_password">
                                                                <i 
                                                                    class="fa fa-eye-slash mb-2 pe-auto" 
                                                                    aria-hidden="true" 
                                                                    id="icon"
                                                                    >
                                                                </i>
                                                            </a>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-3;" id="CheckPasswordMatch"></div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-password-reset-modal" value="add" data-val-id="{{$password_user->id}}">
                        <span class="spinner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
        $(document).ready(function(){
            $('.spinner').hide();

            

            $(document).on('click', ".btn-password-reset", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});
                
                let itemId = $(this).attr('data-val-id');
                $('#password-reset-user-id').val(itemId);
                
                $('#mdl-password-reset-modal').modal('show');
                $('#frm-password-reset-modal').trigger("reset");
            });

            //generate random password
            $(document).on('click', ".generate_random_password", function(e){
                e.preventDefault();
                $('#password1, #password1_confirmation').val(Password.generate(16))
                // $('').val($('#password1').val())
                passwordChecker();
            });

            let Password = {
                _pattern : /[a-zA-Z0-9_\-\+\.]/,
                _getRandomByte : function() {
                    if(window.crypto && window.crypto.getRandomValues){
                        let result = new Uint8Array(1);
                        window.crypto.getRandomValues(result);
                        return result[0];
                    } else if(window.msCrypto && window.msCrypto.getRandomValues) {
                        let result = new Uint8Array(1);
                        window.msCrypto.getRandomValues(result);
                        return result[0];
                    }else {
                        return Math.floor(Math.random() * 256);
                    }
                 },
                generate : function(length){
                    return Array.apply(null, {'length': length}).map(function(){
                        let result;
                        while(true) { 
                            result = String.fromCharCode(this._getRandomByte());
                            if(this._pattern.test(result)) {
                                return result;
                            }
                        }        
                    }, this).join('');  
                    
                }
            };

            function passwordChecker() {
                let password = $("#password1").val();
                let confirmPassword = $("#password1_confirmation").val();
                    if ((password.length > 0 && password != confirmPassword) || (confirmPassword != password)){
                        $("#CheckPasswordMatch").html("Password does not match !").css("color", "red");
                        $("#btn-save-mdl-password-reset-modal").prop('disabled', true);
                    }
                    else{
                        $("#CheckPasswordMatch").html("Password match !").css("color", "green");
                        $("#btn-save-mdl-password-reset-modal").prop('disabled', false);
                    }
                
            }

            $(".toggle_hide_password").on('click', function(e) {
                e.preventDefault()

                // get input group of clicked link
                const input_group = $(this).closest('.input-group')

                // find the input, within the input group
                const input = input_group.find('input.form-control')

                // find the icon, within the input group
                const icon = input_group.find('#icon');
                const lock = input_group.find('#lock')

                // toggle field type
                input.attr('type', input.attr("type") === "text" ? 'password' : 'text')

                // toggle icon class
                icon.toggleClass('fa-eye-slash fa-eye');
                lock.toggleClass('bx bxs-lock-open bx bxs-lock')

            })

             $("#password1_confirmation, #password1").on('keyup', function() {
                passwordChecker();
            });


            //Save details
            $('#btn-save-mdl-password-reset-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


                $(".spinner").show();
                $("#btn-save-mdl-password-reset-modal").prop('disabled', true);
                
                if($("#password1").val().length === 0){
                    $('#password_validation_error').html('');
                    $('#password_validation_error').show();
                    $('#password_validation_error').append(
                        `Password cannot be blank`
                    );
                }else{
                    //implement
                    //get user id
                    let user_id =  $('#password-reset-user-id').val();
                    
                    //call endpoint to update user password
                    let actionType = "POST";
                    let endPointUrl = "{{ route('fc.user.reset-password','') }}/"+user_id;


                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('_method', 'PUT');
                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                    @endif
                    
                    formData.append('password', $('#password1').val());

                    $.ajax({
                        url: endPointUrl,
                        type: actionType,
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {
                            console.log(result, result)
                            if (result.errors) {
                                //implement
                                $('#div-password-reset-modal-error').html('');
                                $('#div-password-reset-modal-error').show();
                                $.each(result.errors, function(key, value) {
                                    $('#div-password-reset-modal-error').append(
                                        '<li class="">' + value + '</li>'
                                    );
                                });
                            } 
                            else {
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

                                    $(".spinner").hide();
                                    $("#btn-save-mdl-password-reset-modal")
                                        .prop('disabled',
                                            false);
                        },
                        error: function(data) {
                                console.log(data);
                                swal("Error",
                                            "Oops an error occurred. Please try again.",
                                            "error");

                                        $(".spinner").hide();
                                        $("#btn-save-mdl-password-reset-modal")
                                            .prop('disabled',
                                                false);
                            }
                        });
                }
            });


        });
    </script>
    @endpush

@endonce
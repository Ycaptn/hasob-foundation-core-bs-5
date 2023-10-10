@if (isset($role_user) && $role_user!=null)
    <a  href="#" 
        title="Change Role" 
        id="btn-{{$control_id}}"
        class="btn-role-selector me-2"
        data-toggle="tooltip" 
        data-val-id="{{$role_user->id}}">
            <i class="fa fa-wrench small"></i>
    </a>
@endif



@once

    <div class="modal fade" id="mdl-role-selector-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 id="lbl-role-selector-modal-title" class="modal-title">Role Selection</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-role-selector-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-role-selector-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">
                                @csrf

                                <div id="spinner-role-selector" class="">
                                    <div class="loader" id="loader-role-selector"></div>
                                </div>

                                <input id="role-select-user-id" type="hidden" value="0" />

                                <div class="row row-cols-2 row-cols-sm-2">
                                    @if (isset($roles) && $roles!=null)
                                    @foreach ($roles as $idx => $role)
                                        <div class="col form-check" >
                                            <input 
                                                id='userRole-{{$role->id}}' 
                                                name='userRole-{{$role->id}}' 
                                                type="checkbox" 
                                                value={{ $role->id }} 
                                                class="role-selector-roles user-role-{{$role->id}} role_checkbox"
                                            />
                                            <span for="userRole-{{$role->id}}">{{ $role->name }}</span>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-role-selector-modal" value="add">Save</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-role-selector-modal" value="add" data-val-id="{{$role_user->id}}">
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

            $(document).on('click', ".btn-role-selector", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});

                let itemId = $(this).attr('data-val-id');
                $('#role-select-user-id').val(itemId);
                $('.role-selector-roles').removeAttr('checked');

                

                $.get("{{ route('fc.user.show','') }}/" + itemId).done(function(response) {
                    $('#mdl-role-selector-modal').modal('show');
                    $('#frm-role-selector-modal').trigger("reset");
                    response.roles.forEach(function(item){
                        $('.user-role-'+item.id).attr('checked',true)
                    });
                });
            });

            function getUserDetails(formData, user_id, endPointUrl, actionType) {
                const user = $('#role-select-user-id').val();
                


                $.ajax({
                    url: "{{ route('fc.user.show','') }}/" + user,
                    type: "GET",
                    data: "string",
                    async: true,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                       if(response){
                          formData.append('phoneNumber', response.telephone)
                          formData.append('emailAddress', response.email)
                          formData.append('department', response.department_id)
                          formData.append('jobTitle', response.job_title)
                          formData.append('title', response.title)
                          formData.append('firstName', response.first_name)
                          formData.append('middleName', response.middle_name)
                          formData.append('lastName', response.last_name);


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
                            $('#div-role-selector-modal-error').html('');
                            $('#div-role-selector-modal-error').show();
                            $.each(result.errors, function(key, value) {
                                $('#div-role-selector-modal-error').append(
                                    '<li class="">' + value + '</li>'
                                );
                            });
                        } else {
                            swal({
                                title: "Saved",
                                text: "Roles updated successfully.",
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
                                $("#btn-save-mdl-role-selector-modal")
                                    .prop('disabled',
                                        false);
                    },
                    error: function(data) {
                        console.log(data);
                         swal("Error",
                                    "Oops an error occurred. Please try again.",
                                    "error");

                                $(".spinner").hide();
                                $("#btn-save-mdl-role-selector-modal")
                                    .prop('disabled',
                                        false);
                    }
                })
                       }

                    }
                })

            }

            // getUserDetails();

            //Save details
            $('#btn-save-mdl-role-selector-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


                let itemId = $(this).attr('data-val-id');
                $('#role-select-user-id').val(itemId);


                $(".spinner").show();
                $("#btn-save-mdl-role-selector-modal").prop('disabled', true);



                let user_id = $('#role-select-user-id').val();
                let actionType = "POST";
                let endPointUrl = "{{ route('fc.user.store', '') }}/"+user_id;
                
                //get user id
                
                //get selected roles
                let selectedRoles = [];

                const checkedRole = $('.role_checkbox:checked');

                $(checkedRole).each(function() {
                    selectedRoles.push($(this).val())
                })


                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                formData.append('role_key', selectedRoles);
                
                getUserDetails(formData, user_id, endPointUrl, actionType);
                

                //implement
                //call endpoint to update user roles

            });

        });
    </script>
    @endpush

@endonce
<div class="modal fade" id="mdl-department-members-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="lbl-department-members-modal-title">Member Selector</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-department-members-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-department-members-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                           

                            <div class="mb-3">
                                <label class="form-label">Members:</label>
                                    <div class="input-group">
                                        <select id="sel_current_member" name="sel_current_member" class="form-select form-select-md" style="width: 100%" placeholder="Select a member">
                                        </select>
                                </div>
                            </div>

                </form>
            </div>

           <div id="div-save-mdl-department-members-modal" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-mdl-department-members-modal" value="add">
                    <span class="spinner">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </span>  
                    Select
                </button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline').hide();
    $('.spinner').hide();

    $("select[id='sel_current_member']").css('width', '100%');
    $("select[id='sel_current_member']").select2({
        width: 'resolve'
    });
    $("select[id='sel_current_member']").select2({
        dropdownParent:$('#mdl-department-members-modal')
    });

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-department-members", function(e) {
        $('#div-department-members-modal-error').hide();
        $('#mdl-department-members-modal').modal('show');
        $('#frm-department-members-modal').trigger("reset");

        $("#spinner-department-members").show();
        $("#div-save-mdl-department-members-modal").attr('disabled', true);

        $('select[id="sel_current_member"]').children('option').remove();

        @if (isset($department))
            $.get( "{{ route('fc.users.index') }}").done(function( response ) {
                $.each(response.data, function(key, value){
                    if (value.department_id !=null || value.department_id !='{{$department->id}}'){
                    full_name = value.last_name+', '+value.first_name;
                    }     
                    if (value.middle_name){
                        full_name += ' '+value.middle_name;
                    }  
                    $('<option>').val(value.id).text(full_name).appendTo('select[id="sel_current_member"]');
                });
                $("#spinner-department-members").hide();
                $("#div-save-mdl-department-members-modal").attr('disabled', false);
            });
        @else
            $("#spinner-department-members").hide();
            $("#div-save-mdl-department-members-modal").attr('disabled', false);
        @endif

    });

    //Save details
    $('#btn-save-mdl-department-members-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        @if (isset($department) == false)
        return;
        @endif

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $(".spinner").show();
        $("#btn-save-mdl-department-members-modal").prop('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc.select-members','') }}/"+$('#sel_current_member').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());        
        formData.append('_method', actionType);
        formData.append('member_id', $('#sel_current_member').val());
        @if (isset($department))
        formData.append('department_id', '{{ $department->id }}');
        @endif

        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        
        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(data){
                console.log(data)
                if(data!=null && data.status=='fail'){
                    $('#div-department-members-modal-error').empty();
                    $('#div-department-members-modal-error').show();
                    if(data.response!=null){
                        if($.isArray(data.response)){
                            $('#div-department-members-modal-error').append('<strong>Error</strong>');
                               $.each(data.response,function(key, value) {
                                   $('#div-department-members-modal-error').append(value+'<br>');
                               });
                        }else{
                            $('#div-department-members-modal-error').html('<strong>Error</strong><br>'+data.response);
                        }

                    }else{
                        $('#div-department-members-modal-error').html('<strong>Error</strong><br>An Error has occurred');
                    }
				
                }else{
                    $('#div-department-members-modal-error').hide();

                        $('#div-department-members-modal-error').hide();
                         swal({
                                title: "Saved",
                                text: "Member Selected successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });
                            window.setTimeout(function(){
                        // location.reload(true);
                    }, 1000);

                }

                $(".spinner").hide();
                $("#btn-save-mdl-department-members-modal").prop('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $(".spinner").hide();
                $("#btn-save-mdl-department-members-modal").prop('disabled', false);

            }
        });
    });

     //Delete Member Action
     $(document).on('click', ".btn-remove-mdl-department-members-modal", function(e) {
                e.preventDefault();        
                let itemId = $(this).attr('data-val');
                console.log(itemId, "itemId")
                swal({
                            title: "Are you sure you want to remove this member from this Department?",
                            text: "You can readd the member back if need be.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                    }, function(isConfirm) {
                    if (isConfirm) {
        
                        let endPointUrl = "{{ route('fc.departments.destroy', '') }}/" + itemId;
                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('_method', 'DELETE');
                     
                        
                        $.ajax({
                            url: endPointUrl,
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
                                            title: "Deleted",
                                            text: "Member Deleted Successfully.",
                                            type: "success",
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false
                                        })
                                        setTimeout(function(){
                                            location.reload(true);
                             }, 1000);
                         }
                    },
                });

            }
        });
    });
});
</script>
@endpush

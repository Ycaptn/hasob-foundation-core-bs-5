
<div class="modal fade" id="mdl-department-unit-modal" tabindex="-1" role= "dialog" aria-labelledby="mdl-department-unit-modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="lbl-department-unit-modal-title">Department</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
  
              <div class="modal-body">
                  <div id="div-department-unit-modal-error" class="alert alert-danger" role="alert"></div>
                  <form class="form-horizontal" id="frm-department-unit-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        @csrf  
                        <input type="hidden" id="txt-department-unit-primary-id" value="0" />
                        
                        <div id="div-edit-txt-department-unit-primary-id">
                            <div class="">
                                @include('hasob-foundation-core::departments.fields')
                            </div>
                        </div>
                  </form>
              </div>
  
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="btn-save-mdl-department-unit-modal" value="add">
                  <span id="spinner1" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  <span class="visually-hidden">Loading...</span>  Save</button>
              </div>
  
          </div>
      </div>
</div>
  
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
        
            //Show Modal for New Entry
            $(document).on('click', ".btn-new-mdl-department-unit-modal", function(e) {
                $('#spinner1').hide();
                $('#div-department-unit-modal-error').hide();
                $('#mdl-department-unit-modal').modal('show');
                $('.modal-footer').show();
                $('#frm-department-unit-modal').trigger("reset");
                $('#txt-department-unit-primary-id').val(0);
        
                $('#div-show-txt-department-unit-primary-id').hide();
                $('#div-edit-txt-department-unit-primary-id').show();
            });
        
            //Show Modal for View
            $(document).on('click', ".btn-show-mdl-department-unit-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                $('#div-department-unit-modal-error').hide();
                $('#mdl-department-unit-modal').modal('show');
                $('#frm-department-unit-modal').trigger("reset");

                $('#spinner').show();
                $('#btn-save-mdl-department-unit-modal').prop("disabled", true);

                let itemId = $(this).attr('data-val');
                $.get( "{{ route('fc.departments.show','') }}/"+itemId).done(function( response ) {
                    $('#div-department-unit-modal-error').hide();
                    $('#mdl-department-unit-modal').modal('show');
                    $('#frm-department-unit-modal').trigger("reset");
                    $('#txt-department-unit-primary-id').val(response.data.id);
                });
            });
        
            //Show Modal for Edit
            $(document).on('click', ".btn-edit-mdl-department-unit-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                
                $('#div-department-unit-modal-error').hide();
                $('#frm-department-unit-modal').trigger("reset");
                $('#mdl-department-unit-modal').modal('show');

                $('#spinner1').show();
                $('#btn-save-mdl-department-unit-modal').prop("disabled", true);

                let itemId = $(this).attr('data-val');        
                $.get( "{{ route('fc.departments.show','') }}/"+itemId).done(function( data ) {

                    $('#txt-department-unit-primary-id').val(data.response.id);
                    $('#email').val(data.response.email);
                    $('#long_name').val(data.response.long_name);
                    $('#telephone').val(data.response.telephone);
                    $('#physical_location').val(data.response.physical_location);
                   /*  if (data.response.parent_id != null){
                        $('#department_id').val(data.response.parent_id);
                    } */

                    $('#spinner1').hide();
                    $('#btn-save-mdl-department-unit-modal').prop("disabled", false);
                    //$('#is_unit').val(data.response.is_unit));
                });
            });
        
            //Delete action
            $(document).on('click', ".btn-delete-mdl-department-unit-modal", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
        
                let itemId = $(this).attr('data-val');
                swal({
                            title: "Are you sure you want to delete this unit record?",
                            text: "You will not be able to recover this unit record if deleted.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                    }, function(isConfirm) {
                    if (isConfirm) {
        
                        let endPointUrl = "{{ route('fc.departments.destroy','') }}/"+itemId;
                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('_method', 'DELETE');
                        
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
                                            title: "Deleted",
                                            text: "The Unit record was deleted successfully.",
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

            //Save details
            $('#btn-save-mdl-department-unit-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spinner1').show();
                $('#btn-save-mdl-department-unit-modal').prop("disabled", true);
                let actionType = "POST";
                let endPointUrl = "{{ route('fc.department.units') }}";
                let primaryId = $('#txt-department-unit-primary-id').val();
                
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
        
                if (primaryId != "0"){
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc.departments.update','') }}/"+primaryId;
                    formData.append('id', primaryId);
                }
                
                formData.append('_method', actionType);
                formData.append('long_name', $('#long_name').val());
                formData.append('email', $('#email').val());
                formData.append('is_unit', $('#is_unit').val());
                formData.append('telephone', $('#telephone').val());
                //formData.append('parent_id', $('#department_id').val());
                formData.append('physical_location', $('#physical_location').val());
                @if (isset($department))
                formData.append('parent_id', '{{ $department->id }}');
                @endif
               /* @if (isset($organization) && $organization!=null)
                formData.append('organization_id', '{{$organization->id}}');
                @endif */
        
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
                            console.log(result.errors);
                            $('#div-department-unit-modal-error').html('');
                            $('#div-department-unit-modal-error').show();
                            $('#spinner1').hide();
                            $('#btn-save-mdl-department-unit-modal').prop("disabled", false);
                            
                            $.each(result.errors, function(key, value){
                                $('#div-department-unit-modal-error').append('<li class="">'+value+'</li>');
                            });
                        }else{
                            $('#div-department-unit-modal-error').hide();
                            $('#spinner1').hide();
                            $('#btn-save-mdl-department-unit-modal').prop("disabled", false);
                            $('#div-department-unit-modal-error').hide();
                            // window.setTimeout( function(){
                            //     window.alert("The Department record saved successfully.");
                            //     location.reload(true);
                            // },20);

                            
                        swal({
                                title: "Saved",
                                text: "The Unit record was saved successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })

                            setTimeout(function(){
                                location.reload(true);
                        }, 1000);

                        }
                    }, error: function(data){
                        $('#spinner1').hide();
                        $('#btn-save-mdl-department-unit-modal').prop("disabled", false);
                        console.log(data);
                    }
                });
            });
        
        });

    </script>  
@endpush
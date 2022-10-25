

<div class="modal fade" id="mdl-modelDocument-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-modelDocument-modal-title" class="modal-title">Model Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-modelDocument-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-modelDocument-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 m-3">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-model_documents">You are currently offline</span></div>

                            <div id="spinner-model_documents" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-modelDocument-primary-id" value="0" />
                            <div id="div-show-txt-modelDocument-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::pages.model_documents.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-modelDocument-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::pages.model_documents.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-modelDocument-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-modelDocument-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-model_documents').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-modelDocument-modal", function(e) {
        $('#div-modelDocument-modal-error').hide();
        $('#mdl-modelDocument-modal').modal('show');
        $('#frm-modelDocument-modal').trigger("reset");
        $('#txt-modelDocument-primary-id').val(0);

        $('#div-show-txt-modelDocument-primary-id').hide();
        $('#div-edit-txt-modelDocument-primary-id').show();

        $("#spinner-model_documents").hide();
        $("#div-save-mdl-modelDocument-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-modelDocument-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_documents').fadeIn(300);
            return;
        }else{
            $('.offline-model_documents').fadeOut(300);
        }

        $('#div-modelDocument-modal-error').hide();
        $('#mdl-modelDocument-modal').modal('show');
        $('#frm-modelDocument-modal').trigger("reset");

        $("#spinner-model_documents").show();
        $("#div-save-mdl-modelDocument-modal").attr('disabled', true);

        $('#div-show-txt-modelDocument-primary-id').show();
        $('#div-edit-txt-modelDocument-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.model_documents.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-modelDocument-primary-id').val(response.data.id);
            		$('#spn_modelDocument_model_primary_id').html(response.data.model_primary_id);


            $("#spinner-model_documents").hide();
            $("#div-save-mdl-modelDocument-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-modelDocument-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-modelDocument-modal-error').hide();
        $('#mdl-modelDocument-modal').modal('show');
        $('#frm-modelDocument-modal').trigger("reset");

        $("#spinner-model_documents").show();
        $("#div-save-mdl-modelDocument-modal").attr('disabled', true);

        $('#div-show-txt-modelDocument-primary-id').hide();
        $('#div-edit-txt-modelDocument-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.model_documents.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-modelDocument-primary-id').val(response.data.id);
            		$('#model_primary_id').val(response.data.model_primary_id);


            $("#spinner-model_documents").hide();
            $("#div-save-mdl-modelDocument-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-modelDocument-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_documents').fadeIn(300);
            return;
        }else{
            $('.offline-model_documents').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this ModelDocument?",
                text: "You will not be able to recover this ModelDocument if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.model_documents.destroy','') }}/"+itemId;

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
                                        text: "ModelDocument deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },function(){
                                        location.reload(true);
                                });
                            }
                        },
                    });
                }
            });

    });

    //Save details
    $('#btn-save-mdl-modelDocument-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_documents').fadeIn(300);
            return;
        }else{
            $('.offline-model_documents').fadeOut(300);
        }

        $("#spinner-model_documents").show();
        $("#div-save-mdl-modelDocument-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.model_documents.store') }}";
        let primaryId = $('#txt-modelDocument-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.model_documents.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		if ($('#model_primary_id').length){	formData.append('model_primary_id',$('#model_primary_id').val());	}


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
					$('#div-modelDocument-modal-error').html('');
					$('#div-modelDocument-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-modelDocument-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-modelDocument-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-modelDocument-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "ModelDocument saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-model_documents").hide();
                $("#div-save-mdl-modelDocument-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-model_documents").hide();
                $("#div-save-mdl-modelDocument-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

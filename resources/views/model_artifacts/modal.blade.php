

<div class="modal fade" id="mdl-modelArtifact-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-modelArtifact-modal-title" class="modal-title">Model Artifact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-modelArtifact-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-modelArtifact-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-model_artifacts">You are currently offline</span></div>

                            <div id="spinner-model_artifacts" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-modelArtifact-primary-id" value="0" />
                            <div id="div-show-txt-modelArtifact-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.model_artifacts.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-modelArtifact-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.model_artifacts.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-modelArtifact-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-modelArtifact-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-model_artifacts').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-modelArtifact-modal", function(e) {
        $('#div-modelArtifact-modal-error').hide();
        $('#mdl-modelArtifact-modal').modal('show');
        $('#frm-modelArtifact-modal').trigger("reset");
        $('#txt-modelArtifact-primary-id').val(0);

        $('#div-show-txt-modelArtifact-primary-id').hide();
        $('#div-edit-txt-modelArtifact-primary-id').show();

        $("#spinner-model_artifacts").hide();
        $("#div-save-mdl-modelArtifact-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-modelArtifact-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_artifacts').fadeIn(300);
            return;
        }else{
            $('.offline-model_artifacts').fadeOut(300);
        }

        $('#div-modelArtifact-modal-error').hide();
        $('#mdl-modelArtifact-modal').modal('show');
        $('#frm-modelArtifact-modal').trigger("reset");

        $("#spinner-model_artifacts").show();
        $("#div-save-mdl-modelArtifact-modal").attr('disabled', true);

        $('#div-show-txt-modelArtifact-primary-id').show();
        $('#div-edit-txt-modelArtifact-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.model_artifacts.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-modelArtifact-primary-id').val(response.data.id);
            		$('#spn_modelArtifact_model_primary_id').html(response.data.model_primary_id);
		$('#spn_modelArtifact_key').html(response.data.key);
		$('#spn_modelArtifact_value').html(response.data.value);


            $("#spinner-model_artifacts").hide();
            $("#div-save-mdl-modelArtifact-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-modelArtifact-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-modelArtifact-modal-error').hide();
        $('#mdl-modelArtifact-modal').modal('show');
        $('#frm-modelArtifact-modal').trigger("reset");

        $("#spinner-model_artifacts").show();
        $("#div-save-mdl-modelArtifact-modal").attr('disabled', true);

        $('#div-show-txt-modelArtifact-primary-id').hide();
        $('#div-edit-txt-modelArtifact-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.model_artifacts.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-modelArtifact-primary-id').val(response.data.id);
            		$('#model_primary_id').val(response.data.model_primary_id);
		$('#key').val(response.data.key);
		$('#value').val(response.data.value);


            $("#spinner-model_artifacts").hide();
            $("#div-save-mdl-modelArtifact-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-modelArtifact-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_artifacts').fadeIn(300);
            return;
        }else{
            $('.offline-model_artifacts').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this ModelArtifact?",
                text: "You will not be able to recover this ModelArtifact if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.model_artifacts.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "ModelArtifact deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "ModelArtifact deleted successfully",
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
    $('#btn-save-mdl-modelArtifact-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-model_artifacts').fadeIn(300);
            return;
        }else{
            $('.offline-model_artifacts').fadeOut(300);
        }

        $("#spinner-model_artifacts").show();
        $("#div-save-mdl-modelArtifact-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.model_artifacts.store') }}";
        let primaryId = $('#txt-modelArtifact-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.model_artifacts.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('model_primary_id', $('#model_primary_id').val());
		formData.append('key', $('#key').val());
		formData.append('value', $('#value').val());


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
					$('#div-modelArtifact-modal-error').html('');
					$('#div-modelArtifact-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-modelArtifact-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-modelArtifact-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-modelArtifact-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "ModelArtifact saved successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-model_artifacts").hide();
                $("#div-save-mdl-modelArtifact-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-model_artifacts").hide();
                $("#div-save-mdl-modelArtifact-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

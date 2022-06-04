

<div class="modal fade" id="mdl-taggable-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-taggable-modal-title" class="modal-title">Taggable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-taggable-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-taggable-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-taggables">You are currently offline</span></div>

                            <div id="spinner-taggables" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-taggable-primary-id" value="0" />
                            <div id="div-show-txt-taggable-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.taggables.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-taggable-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.taggables.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-taggable-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-taggable-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-taggables').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-taggable-modal", function(e) {
        $('#div-taggable-modal-error').hide();
        $('#mdl-taggable-modal').modal('show');
        $('#frm-taggable-modal').trigger("reset");
        $('#txt-taggable-primary-id').val(0);

        $('#div-show-txt-taggable-primary-id').hide();
        $('#div-edit-txt-taggable-primary-id').show();

        $("#spinner-taggables").hide();
        $("#div-save-mdl-taggable-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-taggable-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-taggables').fadeIn(300);
            return;
        }else{
            $('.offline-taggables').fadeOut(300);
        }

        $('#div-taggable-modal-error').hide();
        $('#mdl-taggable-modal').modal('show');
        $('#frm-taggable-modal').trigger("reset");

        $("#spinner-taggables").show();
        $("#div-save-mdl-taggable-modal").attr('disabled', true);

        $('#div-show-txt-taggable-primary-id').show();
        $('#div-edit-txt-taggable-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.taggables.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-taggable-primary-id').val(response.data.id);
            		$('#spn_taggable_taggable_id').html(response.data.taggable_id);


            $("#spinner-taggables").hide();
            $("#div-save-mdl-taggable-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-taggable-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-taggable-modal-error').hide();
        $('#mdl-taggable-modal').modal('show');
        $('#frm-taggable-modal').trigger("reset");

        $("#spinner-taggables").show();
        $("#div-save-mdl-taggable-modal").attr('disabled', true);

        $('#div-show-txt-taggable-primary-id').hide();
        $('#div-edit-txt-taggable-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.taggables.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-taggable-primary-id').val(response.data.id);
            		$('#taggable_id').val(response.data.taggable_id);


            $("#spinner-taggables").hide();
            $("#div-save-mdl-taggable-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-taggable-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-taggables').fadeIn(300);
            return;
        }else{
            $('.offline-taggables').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Taggable?",
                text: "You will not be able to recover this Taggable if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.taggables.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "Taggable deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "Taggable deleted successfully",
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
    $('#btn-save-mdl-taggable-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-taggables').fadeIn(300);
            return;
        }else{
            $('.offline-taggables').fadeOut(300);
        }

        $("#spinner-taggables").show();
        $("#div-save-mdl-taggable-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.taggables.store') }}";
        let primaryId = $('#txt-taggable-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.taggables.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('taggable_id', $('#taggable_id').val());


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
					$('#div-taggable-modal-error').html('');
					$('#div-taggable-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-taggable-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-taggable-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-taggable-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Taggable saved successfully",
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

                $("#spinner-taggables").hide();
                $("#div-save-mdl-taggable-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-taggables").hide();
                $("#div-save-mdl-taggable-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

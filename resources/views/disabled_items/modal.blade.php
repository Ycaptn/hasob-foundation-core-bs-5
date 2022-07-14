

<div class="modal fade" id="mdl-disabledItem-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-disabledItem-modal-title" class="modal-title">Disabled Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-disabledItem-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-disabledItem-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-disabled_items">You are currently offline</span></div>

                            <div id="spinner-disabled_items" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-disabledItem-primary-id" value="0" />
                            <div id="div-show-txt-disabledItem-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.disabled_items.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-disabledItem-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.disabled_items.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-disabledItem-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-disabledItem-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-disabled_items').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-disabledItem-modal", function(e) {
        $('#div-disabledItem-modal-error').hide();
        $('#mdl-disabledItem-modal').modal('show');
        $('#frm-disabledItem-modal').trigger("reset");
        $('#txt-disabledItem-primary-id').val(0);

        $('#div-show-txt-disabledItem-primary-id').hide();
        $('#div-edit-txt-disabledItem-primary-id').show();

        $("#spinner-disabled_items").hide();
        $("#div-save-mdl-disabledItem-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-disabledItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-disabled_items').fadeIn(300);
            return;
        }else{
            $('.offline-disabled_items').fadeOut(300);
        }

        $('#div-disabledItem-modal-error').hide();
        $('#mdl-disabledItem-modal').modal('show');
        $('#frm-disabledItem-modal').trigger("reset");

        $("#spinner-disabled_items").show();
        $("#div-save-mdl-disabledItem-modal").attr('disabled', true);

        $('#div-show-txt-disabledItem-primary-id').show();
        $('#div-edit-txt-disabledItem-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.disabled_items.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-disabledItem-primary-id').val(response.data.id);
            		$('#spn_disabledItem_disable_id').html(response.data.disable_id);
		$('#spn_disabledItem_disable_reason').html(response.data.disable_reason);


            $("#spinner-disabled_items").hide();
            $("#div-save-mdl-disabledItem-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-disabledItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-disabledItem-modal-error').hide();
        $('#mdl-disabledItem-modal').modal('show');
        $('#frm-disabledItem-modal').trigger("reset");

        $("#spinner-disabled_items").show();
        $("#div-save-mdl-disabledItem-modal").attr('disabled', true);

        $('#div-show-txt-disabledItem-primary-id').hide();
        $('#div-edit-txt-disabledItem-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.disabled_items.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-disabledItem-primary-id').val(response.data.id);
            		$('#disable_id').val(response.data.disable_id);
		$('#disable_reason').val(response.data.disable_reason);


            $("#spinner-disabled_items").hide();
            $("#div-save-mdl-disabledItem-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-disabledItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-disabled_items').fadeIn(300);
            return;
        }else{
            $('.offline-disabled_items').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this DisabledItem?",
                text: "You will not be able to recover this DisabledItem if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.disabled_items.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "DisabledItem deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "DisabledItem deleted successfully",
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
    $('#btn-save-mdl-disabledItem-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-disabled_items').fadeIn(300);
            return;
        }else{
            $('.offline-disabled_items').fadeOut(300);
        }

        $("#spinner-disabled_items").show();
        $("#div-save-mdl-disabledItem-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.disabled_items.store') }}";
        let primaryId = $('#txt-disabledItem-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.disabled_items.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('disable_id', $('#disable_id').val());
		formData.append('disable_reason', $('#disable_reason').val());


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
					$('#div-disabledItem-modal-error').html('');
					$('#div-disabledItem-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-disabledItem-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-disabledItem-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-disabledItem-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "DisabledItem saved successfully",
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

                $("#spinner-disabled_items").hide();
                $("#div-save-mdl-disabledItem-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-disabled_items").hide();
                $("#div-save-mdl-disabledItem-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

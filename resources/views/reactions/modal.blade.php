

<div class="modal fade" id="mdl-reaction-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-reaction-modal-title" class="modal-title">Reaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-reaction-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-reaction-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    
                        <div class="col-lg-12 pe-2">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-reactions">You are currently offline</span></div>

                            <div id="spinner-reactions" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-reaction-primary-id" value="0" />
                            <div id="div-show-txt-reaction-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::pages.reactions.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-reaction-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::pages.reactions.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-reaction-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-reaction-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-reactions').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-reaction-modal", function(e) {
        $('#div-reaction-modal-error').hide();
        $('#mdl-reaction-modal').modal('show');
        $('#frm-reaction-modal').trigger("reset");
        $('#txt-reaction-primary-id').val(0);

        $('#div-show-txt-reaction-primary-id').hide();
        $('#div-edit-txt-reaction-primary-id').show();

        $("#spinner-reactions").hide();
        $("#div-save-mdl-reaction-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-reaction-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-reactions').fadeIn(300);
            return;
        }else{
            $('.offline-reactions').fadeOut(300);
        }

        $('#div-reaction-modal-error').hide();
        $('#mdl-reaction-modal').modal('show');
        $('#frm-reaction-modal').trigger("reset");

        $("#spinner-reactions").show();
        $("#div-save-mdl-reaction-modal").attr('disabled', true);

        $('#div-show-txt-reaction-primary-id').show();
        $('#div-edit-txt-reaction-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.reactions.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-reaction-primary-id').val(response.data.id);
            

            $("#spinner-reactions").hide();
            $("#div-save-mdl-reaction-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-reaction-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-reaction-modal-error').hide();
        $('#mdl-reaction-modal').modal('show');
        $('#frm-reaction-modal').trigger("reset");

        $("#spinner-reactions").show();
        $("#div-save-mdl-reaction-modal").attr('disabled', true);

        $('#div-show-txt-reaction-primary-id').hide();
        $('#div-edit-txt-reaction-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.reactions.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-reaction-primary-id').val(response.data.id);
            

            $("#spinner-reactions").hide();
            $("#div-save-mdl-reaction-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-reaction-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-reactions').fadeIn(300);
            return;
        }else{
            $('.offline-reactions').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Reaction?",
                text: "You will not be able to recover this Reaction if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: '<div id="spinner-reactions" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
                        text: 'Deleting Reaction.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        html: true
                    }) 
                                        
                    let endPointUrl = "{{ route('fc-api.reactions.destroy','') }}/"+itemId;

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
                                        text: "Reaction deleted successfully",
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
    $('#btn-save-mdl-reaction-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-reactions').fadeIn(300);
            return;
        }else{
            $('.offline-reactions').fadeOut(300);
        }

        $("#spinner-reactions").show();
        $("#div-save-mdl-reaction-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.reactions.store') }}";
        let primaryId = $('#txt-reaction-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.reactions.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        

        {{-- 
        swal({
            title: '<div id="spinner-reactions" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
            text: 'Saving Reaction',
            showConfirmButton: false,
            allowOutsideClick: false,
            html: true
        })
        --}}
        
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
					$('#div-reaction-modal-error').html('');
					$('#div-reaction-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-reaction-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-reaction-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-reaction-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Reaction saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-reactions").hide();
                $("#div-save-mdl-reaction-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-reactions").hide();
                $("#div-save-mdl-reaction-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush



<div class="modal fade" id="mdl-support-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 id="lbl-support-modal-title" class="modal-title">Support</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-support-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-support-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-supports" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-support-primary-id" value="0" />
                            <div id="div-show-txt-support-primary-id">
                                <div class="row">
                                    <div class="col-lg-11 ma-10">                            
                                    @include('hasob-foundation-core::supports.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-support-primary-id">
                                <div class="row">
                                    <div class="col-lg-11 ma-10">
                                    @include('hasob-foundation-core::supports.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-support-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-support-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-support-modal", function(e) {
        $('#div-support-modal-error').hide();
        $('#mdl-support-modal').modal('show');
        $('#frm-support-modal').trigger("reset");
        $('#txt-support-primary-id').val(0);

        $('#div-show-txt-support-primary-id').hide();
        $('#div-edit-txt-support-primary-id').show();

        $("#spinner-supports").hide();
        $("#div-save-mdl-support-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-support-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $('#div-support-modal-error').hide();
        $('#mdl-support-modal').modal('show');
        $('#frm-support-modal').trigger("reset");

        $("#spinner-supports").show();
        $("#div-save-mdl-support-modal").attr('disabled', true);

        $('#div-show-txt-support-primary-id').show();
        $('#div-edit-txt-support-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.supports.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-support-primary-id').val(response.data.id);
            		$('#spn_support_label').html(response.data.label);
		


            $("#spinner-supports").hide();
            $("#div-save-mdl-support-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-support-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-support-modal-error').hide();
        $('#mdl-support-modal').modal('show');
        $('#frm-support-modal').trigger("reset");

        $("#spinner-supports").show();
        $("#div-save-mdl-support-modal").attr('disabled', true);

        $('#div-show-txt-support-primary-id').hide();
        $('#div-edit-txt-support-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.supports.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-support-primary-id').val(response.data.id);
            		$('#location').val(response.data.location);
                    $('#support_type').val(response.data.support_type);
                    $('#issue_type').val(response.data.issue_type);
                    $('#severity').val(response.data.severity);
                    $('#description').val(response.data.description);


            $("#spinner-supports").hide();
            $("#div-save-mdl-support-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-support-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this support?",
                text: "You will not be able to recover this support if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.supports.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "support deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "support deleted successfully",
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
    $('#btn-save-mdl-support-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $("#spinner-supports").show();
        $("#div-save-mdl-support-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.supports.store') }}";
        let primaryId = $('#txt-support-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.supports.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('location', $('#location').val());
                formData.append('support_type', $('#support_type').val());
                formData.append('issue_type',$('#issue_type').val());
                formData.append('severity',$('#severity').val());
                formData.append('description',$('#description').val())
                formData.append('creator_user_id',"{{auth()->user()->id}}")
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
					$('#div-support-modal-error').html('');
					$('#div-support-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-support-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-support-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-support-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "support saved successfully",
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

                $("#spinner-supports").hide();
                $("#div-save-mdl-support-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-supports").hide();
                $("#div-save-mdl-support-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush



<div class="modal fade" id="mdl-site-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 id="lbl-site-modal-title" class="modal-title">Site</h4>
            </div>

            <div class="modal-body">
                <div id="div-site-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-site-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-sites" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-site-primary-id" value="0" />
                            <div id="div-show-txt-site-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-foundation-core::sites.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-site-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-foundation-core::sites.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-site-modal" class="modal-footer">
                <hr class="light-grey-hr mb-10" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-site-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-site-modal", function(e) {
        $('#div-site-modal-error').hide();
        $('#mdl-site-modal').modal('show');
        $('#frm-site-modal').trigger("reset");
        $('#txt-site-primary-id').val(0);

        $('#div-show-txt-site-primary-id').hide();
        $('#div-edit-txt-site-primary-id').show();

        $("#spinner-sites").hide();
        $("#div-save-mdl-site-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-site-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $('#div-site-modal-error').hide();
        $('#mdl-site-modal').modal('show');
        $('#frm-site-modal').trigger("reset");

        $("#spinner-sites").show();
        $("#div-save-mdl-site-modal").attr('disabled', true);

        $('#div-show-txt-site-primary-id').show();
        $('#div-edit-txt-site-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.sites.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-site-primary-id').val(response.data.id);
            // $('#spn_site_').html(response.data.);
            $('#spn_site_site_name').html(response.data.site_name);
		    $('#spn_site_site_path').html(response.data.site_path);
		    $('#spn_site_description').html(response.data.description);

            $("#spinner-sites").hide();
            $("#div-save-mdl-site-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-site-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-site-modal-error').hide();
        $('#mdl-site-modal').modal('show');
        $('#frm-site-modal').trigger("reset");

        $("#spinner-sites").show();
        $("#div-save-mdl-site-modal").attr('disabled', true);

        $('#div-show-txt-site-primary-id').hide();
        $('#div-edit-txt-site-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.sites.show','') }}/"+itemId).done(function( response ) {     
			$('#txt-site-primary-id').val(response.data.id);
            // $('#').val(response.data.);
            $('#site_name').val(response.data.site_name);
		    $('#site_path').val(response.data.site_path);
		    $('#site_description').val(response.data.description);

            $("#spinner-sites").hide();
            $("#div-save-mdl-site-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-site-modal", function(e) {
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
                title: "Are you sure you want to delete this Site record?",
                text: "You will not be able to recover this Site record if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.sites.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "Site deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "Site deleted successfully",
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
    $('#btn-save-mdl-site-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline').fadeIn(300);
            return;
        }else{
            $('.offline').fadeOut(300);
        }

        $("#spinner-sites").show();
        $("#div-save-mdl-site-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.sites.store') }}";
        let primaryId = $('#txt-site-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc.sites.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        formData.append('creator_user_id', "{{ Auth::id() }}");
        formData.append('site_name', $('#site_name').val());
		//formData.append('site_path', $('#site_path').val());
		formData.append('description', $('#site_description').val());


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
					$('#div-site-modal-error').html('');
					$('#div-site-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-site-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-site-modal-error').hide();
                    window.setTimeout( function(){
                        //window.alert("The Site saved successfully.");
                        //swal("Saved", "Site saved successfully.", "success");

                        $('#div-site-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Site saved successfully",
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

                $("#spinner-sites").hide();
                $("#div-save-mdl-site-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-sites").hide();
                $("#div-save-mdl-site-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush
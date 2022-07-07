

<div class="modal fade" id="mdl-tag-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-tag-modal-title" class="modal-title">Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-tag-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-tag-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-tags">You are currently offline</span></div>

                            <div id="spinner-tags" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-tag-primary-id" value="0" />
                            <div id="div-show-txt-tag-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.tags.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-tag-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.tags.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-tag-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-tag-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-tags').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-tag-modal", function(e) {
        $('#div-tag-modal-error').hide();
        $('#mdl-tag-modal').modal('show');
        $('#frm-tag-modal').trigger("reset");
        $('#txt-tag-primary-id').val(0);

        $('#div-show-txt-tag-primary-id').hide();
        $('#div-edit-txt-tag-primary-id').show();

        $("#spinner-tags").hide();
        $("#div-save-mdl-tag-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-tag-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-tags').fadeIn(300);
            return;
        }else{
            $('.offline-tags').fadeOut(300);
        }

        $('#div-tag-modal-error').hide();
        $('#mdl-tag-modal').modal('show');
        $('#frm-tag-modal').trigger("reset");

        $("#spinner-tags").show();
        $("#div-save-mdl-tag-modal").attr('disabled', true);

        $('#div-show-txt-tag-primary-id').show();
        $('#div-edit-txt-tag-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.tags.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-tag-primary-id').val(response.data.id);
            		$('#spn_tag_parent_id').html(response.data.parent_id);
		$('#spn_tag_name').html(response.data.name);
		$('#spn_tag_meta_data').html(response.data.meta_data);


            $("#spinner-tags").hide();
            $("#div-save-mdl-tag-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-tag-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-tag-modal-error').hide();
        $('#mdl-tag-modal').modal('show');
        $('#frm-tag-modal').trigger("reset");

        $("#spinner-tags").show();
        $("#div-save-mdl-tag-modal").attr('disabled', true);

        $('#div-show-txt-tag-primary-id').hide();
        $('#div-edit-txt-tag-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.tags.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-tag-primary-id').val(response.data.id);
            		$('#parent_id').val(response.data.parent_id);
		$('#name').val(response.data.name);
		$('#meta_data').val(response.data.meta_data);


            $("#spinner-tags").hide();
            $("#div-save-mdl-tag-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-tag-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-tags').fadeIn(300);
            return;
        }else{
            $('.offline-tags').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Tag?",
                text: "You will not be able to recover this Tag if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.tags.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "Tag deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "Tag deleted successfully",
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
    $('#btn-save-mdl-tag-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-tags').fadeIn(300);
            return;
        }else{
            $('.offline-tags').fadeOut(300);
        }

        $("#spinner-tags").show();
        $("#div-save-mdl-tag-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.tags.store') }}";
        let primaryId = $('#txt-tag-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.tags.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('parent_id', $('#parent_id').val());
		formData.append('name', $('#name').val());
		formData.append('meta_data', $('#meta_data').val());


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
					$('#div-tag-modal-error').html('');
					$('#div-tag-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-tag-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-tag-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-tag-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Tag saved successfully",
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

                $("#spinner-tags").hide();
                $("#div-save-mdl-tag-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-tags").hide();
                $("#div-save-mdl-tag-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush



<div class="modal fade" id="mdl-fiscalYear-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-fiscalYear-modal-title" class="modal-title">Fiscal Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-fiscalYear-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-fiscalYear-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-fiscal_years">You are currently offline</span></div>

                            <div id="spinner-fiscal_years" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-fiscalYear-primary-id" value="0" />
                            <div id="div-show-txt-fiscalYear-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.fiscal_years.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-fiscalYear-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.fiscal_years.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-fiscalYear-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-fiscalYear-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-fiscal_years').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-fiscalYear-modal", function(e) {
        $('#div-fiscalYear-modal-error').hide();
        $('#mdl-fiscalYear-modal').modal('show');
        $('#frm-fiscalYear-modal').trigger("reset");
        $('#txt-fiscalYear-primary-id').val(0);

        $('#div-show-txt-fiscalYear-primary-id').hide();
        $('#div-edit-txt-fiscalYear-primary-id').show();

        $("#spinner-fiscal_years").hide();
        $("#div-save-mdl-fiscalYear-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-fiscalYear-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_years').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_years').fadeOut(300);
        }

        $('#div-fiscalYear-modal-error').hide();
        $('#mdl-fiscalYear-modal').modal('show');
        $('#frm-fiscalYear-modal').trigger("reset");

        $("#spinner-fiscal_years").show();
        $("#div-save-mdl-fiscalYear-modal").attr('disabled', true);

        $('#div-show-txt-fiscalYear-primary-id').show();
        $('#div-edit-txt-fiscalYear-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.fiscal_years.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-fiscalYear-primary-id').val(response.data.id);
            		$('#spn_fiscalYear_name').html(response.data.name);
		$('#spn_fiscalYear_status').html(response.data.status);
		$('#spn_fiscalYear_start_date').html(response.data.start_date);
		$('#spn_fiscalYear_end_date').html(response.data.end_date);


            $("#spinner-fiscal_years").hide();
            $("#div-save-mdl-fiscalYear-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-fiscalYear-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-fiscalYear-modal-error').hide();
        $('#mdl-fiscalYear-modal').modal('show');
        $('#frm-fiscalYear-modal').trigger("reset");

        $("#spinner-fiscal_years").show();
        $("#div-save-mdl-fiscalYear-modal").attr('disabled', true);

        $('#div-show-txt-fiscalYear-primary-id').hide();
        $('#div-edit-txt-fiscalYear-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.fiscal_years.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-fiscalYear-primary-id').val(response.data.id);
            		$('#name').val(response.data.name);
		$('#status').val(response.data.status);
		$('#start_date').val(response.data.start_date);
		$('#end_date').val(response.data.end_date);


            $("#spinner-fiscal_years").hide();
            $("#div-save-mdl-fiscalYear-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-fiscalYear-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_years').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_years').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this FiscalYear?",
                text: "You will not be able to recover this FiscalYear if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.fiscal_years.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "FiscalYear deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "FiscalYear deleted successfully",
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
    $('#btn-save-mdl-fiscalYear-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_years').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_years').fadeOut(300);
        }

        $("#spinner-fiscal_years").show();
        $("#div-save-mdl-fiscalYear-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.fiscal_years.store') }}";
        let primaryId = $('#txt-fiscalYear-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.fiscal_years.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('name', $('#name').val());
		formData.append('status', $('#status').val());
		formData.append('start_date', $('#start_date').val());
		formData.append('end_date', $('#end_date').val());


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
					$('#div-fiscalYear-modal-error').html('');
					$('#div-fiscalYear-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-fiscalYear-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-fiscalYear-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-fiscalYear-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "FiscalYear saved successfully",
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

                $("#spinner-fiscal_years").hide();
                $("#div-save-mdl-fiscalYear-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-fiscal_years").hide();
                $("#div-save-mdl-fiscalYear-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

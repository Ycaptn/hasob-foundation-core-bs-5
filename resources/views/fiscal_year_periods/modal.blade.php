

<div class="modal fade" id="mdl-fiscalYearPeriod-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-fiscalYearPeriod-modal-title" class="modal-title">Fiscal Year Period</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-fiscalYearPeriod-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-fiscalYearPeriod-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-fiscal_year_periods">You are currently offline</span></div>

                            <div id="spinner-fiscal_year_periods" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-fiscalYearPeriod-primary-id" value="0" />
                            <div id="div-show-txt-fiscalYearPeriod-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.fiscal_year_periods.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-fiscalYearPeriod-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.fiscal_year_periods.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-fiscalYearPeriod-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-fiscalYearPeriod-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-fiscal_year_periods').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-fiscalYearPeriod-modal", function(e) {
        $('#div-fiscalYearPeriod-modal-error').hide();
        $('#mdl-fiscalYearPeriod-modal').modal('show');
        $('#frm-fiscalYearPeriod-modal').trigger("reset");
        $('#txt-fiscalYearPeriod-primary-id').val(0);

        $('#div-show-txt-fiscalYearPeriod-primary-id').hide();
        $('#div-edit-txt-fiscalYearPeriod-primary-id').show();

        $("#spinner-fiscal_year_periods").hide();
        $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-fiscalYearPeriod-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_year_periods').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_year_periods').fadeOut(300);
        }

        $('#div-fiscalYearPeriod-modal-error').hide();
        $('#mdl-fiscalYearPeriod-modal').modal('show');
        $('#frm-fiscalYearPeriod-modal').trigger("reset");

        $("#spinner-fiscal_year_periods").show();
        $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', true);

        $('#div-show-txt-fiscalYearPeriod-primary-id').show();
        $('#div-edit-txt-fiscalYearPeriod-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.fiscal_year_periods.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-fiscalYearPeriod-primary-id').val(response.data.id);
            		$('#spn_fiscalYearPeriod_name').html(response.data.name);
		$('#spn_fiscalYearPeriod_status').html(response.data.status);
		$('#spn_fiscalYearPeriod_start_date').html(response.data.start_date);
		$('#spn_fiscalYearPeriod_end_date').html(response.data.end_date);


            $("#spinner-fiscal_year_periods").hide();
            $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-fiscalYearPeriod-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-fiscalYearPeriod-modal-error').hide();
        $('#mdl-fiscalYearPeriod-modal').modal('show');
        $('#frm-fiscalYearPeriod-modal').trigger("reset");

        $("#spinner-fiscal_year_periods").show();
        $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', true);

        $('#div-show-txt-fiscalYearPeriod-primary-id').hide();
        $('#div-edit-txt-fiscalYearPeriod-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.fiscal_year_periods.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-fiscalYearPeriod-primary-id').val(response.data.id);
            		$('#name').val(response.data.name);
		$('#status').val(response.data.status);
		$('#start_date').val(response.data.start_date);
		$('#end_date').val(response.data.end_date);


            $("#spinner-fiscal_year_periods").hide();
            $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-fiscalYearPeriod-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_year_periods').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_year_periods').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this FiscalYearPeriod?",
                text: "You will not be able to recover this FiscalYearPeriod if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.fiscal_year_periods.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "FiscalYearPeriod deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "FiscalYearPeriod deleted successfully",
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
    $('#btn-save-mdl-fiscalYearPeriod-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-fiscal_year_periods').fadeIn(300);
            return;
        }else{
            $('.offline-fiscal_year_periods').fadeOut(300);
        }

        $("#spinner-fiscal_year_periods").show();
        $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.fiscal_year_periods.store') }}";
        let primaryId = $('#txt-fiscalYearPeriod-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.fiscal_year_periods.update','') }}/"+primaryId;
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
					$('#div-fiscalYearPeriod-modal-error').html('');
					$('#div-fiscalYearPeriod-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-fiscalYearPeriod-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-fiscalYearPeriod-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-fiscalYearPeriod-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "FiscalYearPeriod saved successfully",
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

                $("#spinner-fiscal_year_periods").hide();
                $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-fiscal_year_periods").hide();
                $("#div-save-mdl-fiscalYearPeriod-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

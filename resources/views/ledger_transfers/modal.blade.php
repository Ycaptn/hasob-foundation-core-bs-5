

<div class="modal fade" id="mdl-ledgerTransfer-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-ledgerTransfer-modal-title" class="modal-title">Ledger Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-ledgerTransfer-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-ledgerTransfer-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-ledger_transfers">You are currently offline</span></div>

                            <div id="spinner-ledger_transfers" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-ledgerTransfer-primary-id" value="0" />
                            <div id="div-show-txt-ledgerTransfer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.ledger_transfers.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-ledgerTransfer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.ledger_transfers.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-ledgerTransfer-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-ledgerTransfer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-ledger_transfers').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-ledgerTransfer-modal", function(e) {
        $('#div-ledgerTransfer-modal-error').hide();
        $('#mdl-ledgerTransfer-modal').modal('show');
        $('#frm-ledgerTransfer-modal').trigger("reset");
        $('#txt-ledgerTransfer-primary-id').val(0);

        $('#div-show-txt-ledgerTransfer-primary-id').hide();
        $('#div-edit-txt-ledgerTransfer-primary-id').show();

        $("#spinner-ledger_transfers").hide();
        $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-ledgerTransfer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-ledger_transfers').fadeIn(300);
            return;
        }else{
            $('.offline-ledger_transfers').fadeOut(300);
        }

        $('#div-ledgerTransfer-modal-error').hide();
        $('#mdl-ledgerTransfer-modal').modal('show');
        $('#frm-ledgerTransfer-modal').trigger("reset");

        $("#spinner-ledger_transfers").show();
        $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', true);

        $('#div-show-txt-ledgerTransfer-primary-id').show();
        $('#div-edit-txt-ledgerTransfer-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.ledger_transfers.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-ledgerTransfer-primary-id').val(response.data.id);
            		$('#spn_ledgerTransfer_name').html(response.data.name);
		$('#spn_ledgerTransfer_status').html(response.data.status);
		$('#spn_ledgerTransfer_closing_balance_amount').html(response.data.closing_balance_amount);
		$('#spn_ledgerTransfer_start_date').html(response.data.start_date);
		$('#spn_ledgerTransfer_end_date').html(response.data.end_date);


            $("#spinner-ledger_transfers").hide();
            $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-ledgerTransfer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-ledgerTransfer-modal-error').hide();
        $('#mdl-ledgerTransfer-modal').modal('show');
        $('#frm-ledgerTransfer-modal').trigger("reset");

        $("#spinner-ledger_transfers").show();
        $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', true);

        $('#div-show-txt-ledgerTransfer-primary-id').hide();
        $('#div-edit-txt-ledgerTransfer-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.ledger_transfers.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-ledgerTransfer-primary-id').val(response.data.id);
            		$('#name').val(response.data.name);
		$('#status').val(response.data.status);
		$('#closing_balance_amount').val(response.data.closing_balance_amount);
		$('#start_date').val(response.data.start_date);
		$('#end_date').val(response.data.end_date);


            $("#spinner-ledger_transfers").hide();
            $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-ledgerTransfer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-ledger_transfers').fadeIn(300);
            return;
        }else{
            $('.offline-ledger_transfers').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this LedgerTransfer?",
                text: "You will not be able to recover this LedgerTransfer if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.ledger_transfers.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "LedgerTransfer deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "LedgerTransfer deleted successfully",
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
    $('#btn-save-mdl-ledgerTransfer-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-ledger_transfers').fadeIn(300);
            return;
        }else{
            $('.offline-ledger_transfers').fadeOut(300);
        }

        $("#spinner-ledger_transfers").show();
        $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.ledger_transfers.store') }}";
        let primaryId = $('#txt-ledgerTransfer-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.ledger_transfers.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('name', $('#name').val());
		formData.append('status', $('#status').val());
		formData.append('closing_balance_amount', $('#closing_balance_amount').val());
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
					$('#div-ledgerTransfer-modal-error').html('');
					$('#div-ledgerTransfer-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-ledgerTransfer-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-ledgerTransfer-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-ledgerTransfer-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "LedgerTransfer saved successfully",
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

                $("#spinner-ledger_transfers").hide();
                $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-ledger_transfers").hide();
                $("#div-save-mdl-ledgerTransfer-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush



<div class="modal fade" id="mdl-paymentDisbursement-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-paymentDisbursement-modal-title" class="modal-title">Payment Disbursement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-paymentDisbursement-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-paymentDisbursement-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    
                        <div class="col-lg-12 pe-2">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-payment_disbursements">You are currently offline</span></div>

                            <div id="spinner-payment_disbursements" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-paymentDisbursement-primary-id" value="0" />
                            <div id="div-show-txt-paymentDisbursement-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::payment_disbursements.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-paymentDisbursement-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundation-core::payment_disbursements.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-paymentDisbursement-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-paymentDisbursement-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-payment_disbursements').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-paymentDisbursement-modal", function(e) {
        $('#div-paymentDisbursement-modal-error').hide();
        $('#mdl-paymentDisbursement-modal').modal('show');
        $('#frm-paymentDisbursement-modal').trigger("reset");
        $('#txt-paymentDisbursement-primary-id').val(0);

        $('#div-show-txt-paymentDisbursement-primary-id').hide();
        $('#div-edit-txt-paymentDisbursement-primary-id').show();

        $("#spinner-payment_disbursements").hide();
        $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-paymentDisbursement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-payment_disbursements').fadeIn(300);
            return;
        }else{
            $('.offline-payment_disbursements').fadeOut(300);
        }

        $('#div-paymentDisbursement-modal-error').hide();
        $('#mdl-paymentDisbursement-modal').modal('show');
        $('#frm-paymentDisbursement-modal').trigger("reset");

        $("#spinner-payment_disbursements").show();
        $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', true);

        $('#div-show-txt-paymentDisbursement-primary-id').show();
        $('#div-edit-txt-paymentDisbursement-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('tet-att-api.payment_disbursements.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-paymentDisbursement-primary-id').val(response.data.id);
            		$('#spn_paymentDisbursement_amount').html(response.data.amount);
		$('#spn_paymentDisbursement_payable_type').html(response.data.payable_type);
		$('#spn_paymentDisbursement_payable_id').html(response.data.payable_id);
		$('#spn_paymentDisbursement_bank_account_number').html(response.data.bank_account_number);
		$('#spn_paymentDisbursement_bank_name').html(response.data.bank_name);
		$('#spn_paymentDisbursement_bank_sort_code').html(response.data.bank_sort_code);
		$('#spn_paymentDisbursement_gateway_reference_code').html(response.data.gateway_reference_code);
		$('#spn_paymentDisbursement_status').html(response.data.status);
		$('#spn_paymentDisbursement_gateway_initialization_response').html(response.data.gateway_initialization_response);
		$('#spn_paymentDisbursement_payment_instrument_type').html(response.data.payment_instrument_type);
		$('#spn_paymentDisbursement_payment_instrument_type').html(response.data.payment_instrument_type);
		$('#spn_paymentDisbursement_is_verified').html(response.data.is_verified);
		$('#spn_paymentDisbursement_is_verification_passed').html(response.data.is_verification_passed);
		$('#spn_paymentDisbursement_is_verification_failed').html(response.data.is_verification_failed);
		$('#spn_paymentDisbursement_transaction_date').html(response.data.transaction_date);
		$('#spn_paymentDisbursement_verified_amount').html(response.data.verified_amount);
		$('#spn_paymentDisbursement_verification_meta').html(response.data.verification_meta);
		$('#spn_paymentDisbursement_verification_notes').html(response.data.verification_notes);


            $("#spinner-payment_disbursements").hide();
            $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-paymentDisbursement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-paymentDisbursement-modal-error').hide();
        $('#mdl-paymentDisbursement-modal').modal('show');
        $('#frm-paymentDisbursement-modal').trigger("reset");

        $("#spinner-payment_disbursements").show();
        $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', true);

        $('#div-show-txt-paymentDisbursement-primary-id').hide();
        $('#div-edit-txt-paymentDisbursement-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('tet-att-api.payment_disbursements.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-paymentDisbursement-primary-id').val(response.data.id);
            		$('#amount').val(response.data.amount);
		$('#payable_type').val(response.data.payable_type);
		$('#payable_id').val(response.data.payable_id);
		$('#bank_account_number').val(response.data.bank_account_number);
		$('#bank_name').val(response.data.bank_name);
		$('#bank_sort_code').val(response.data.bank_sort_code);
		$('#gateway_reference_code').val(response.data.gateway_reference_code);
		$('#status').val(response.data.status);
		$('#gateway_initialization_response').val(response.data.gateway_initialization_response);
		$('#payment_instrument_type').val(response.data.payment_instrument_type);
		$('#payment_instrument_type').val(response.data.payment_instrument_type);
		$('#is_verified').val(response.data.is_verified);
		$('#is_verification_passed').val(response.data.is_verification_passed);
		$('#is_verification_failed').val(response.data.is_verification_failed);
		$('#transaction_date').val(response.data.transaction_date);
		$('#verified_amount').val(response.data.verified_amount);
		$('#verification_meta').val(response.data.verification_meta);
		$('#verification_notes').val(response.data.verification_notes);


            $("#spinner-payment_disbursements").hide();
            $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-paymentDisbursement-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-payment_disbursements').fadeIn(300);
            return;
        }else{
            $('.offline-payment_disbursements').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this PaymentDisbursement?",
                text: "You will not be able to recover this PaymentDisbursement if deleted.",
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
                        title: '<div id="spinner-payment_disbursements" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
                        text: 'Deleting PaymentDisbursement.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        html: true
                    }) 
                                        
                    let endPointUrl = "{{ route('tet-att-api.payment_disbursements.destroy','') }}/"+itemId;

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
                                        text: "PaymentDisbursement deleted successfully",
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
    $('#btn-save-mdl-paymentDisbursement-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-payment_disbursements').fadeIn(300);
            return;
        }else{
            $('.offline-payment_disbursements').fadeOut(300);
        }

        $("#spinner-payment_disbursements").show();
        $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('tet-att-api.payment_disbursements.store') }}";
        let primaryId = $('#txt-paymentDisbursement-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('tet-att-api.payment_disbursements.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		if ($('#amount').length){	formData.append('amount',$('#amount').val());	}
		if ($('#payable_type').length){	formData.append('payable_type',$('#payable_type').val());	}
		if ($('#payable_id').length){	formData.append('payable_id',$('#payable_id').val());	}
		if ($('#bank_account_number').length){	formData.append('bank_account_number',$('#bank_account_number').val());	}
		if ($('#bank_name').length){	formData.append('bank_name',$('#bank_name').val());	}
		if ($('#bank_sort_code').length){	formData.append('bank_sort_code',$('#bank_sort_code').val());	}
		if ($('#gateway_reference_code').length){	formData.append('gateway_reference_code',$('#gateway_reference_code').val());	}
		if ($('#status').length){	formData.append('status',$('#status').val());	}
		if ($('#gateway_initialization_response').length){	formData.append('gateway_initialization_response',$('#gateway_initialization_response').val());	}
		if ($('#payment_instrument_type').length){	formData.append('payment_instrument_type',$('#payment_instrument_type').val());	}
		if ($('#payment_instrument_type').length){	formData.append('payment_instrument_type',$('#payment_instrument_type').val());	}
		if ($('#is_verified').length){	formData.append('is_verified',$('#is_verified').val());	}
		if ($('#is_verification_passed').length){	formData.append('is_verification_passed',$('#is_verification_passed').val());	}
		if ($('#is_verification_failed').length){	formData.append('is_verification_failed',$('#is_verification_failed').val());	}
		if ($('#transaction_date').length){	formData.append('transaction_date',$('#transaction_date').val());	}
		if ($('#verified_amount').length){	formData.append('verified_amount',$('#verified_amount').val());	}
		if ($('#verification_meta').length){	formData.append('verification_meta',$('#verification_meta').val());	}
		if ($('#verification_notes').length){	formData.append('verification_notes',$('#verification_notes').val());	}


        {{-- 
        swal({
            title: '<div id="spinner-payment_disbursements" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
            text: 'Saving PaymentDisbursement',
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
					$('#div-paymentDisbursement-modal-error').html('');
					$('#div-paymentDisbursement-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-paymentDisbursement-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-paymentDisbursement-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-paymentDisbursement-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "PaymentDisbursement saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-payment_disbursements").hide();
                $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-payment_disbursements").hide();
                $("#div-save-mdl-paymentDisbursement-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

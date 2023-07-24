

<div class="modal fade" id="mdl-gateWayPaymentDetail-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-gateWayPaymentDetail-modal-title" class="modal-title">Gate Way Payment Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-gateWayPaymentDetail-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-gateWayPaymentDetail-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    
                        <div class="col-lg-12 pe-2">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-gate_way_payment_details">You are currently offline</span></div>

                            <div id="spinner-gate_way_payment_details" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-gateWayPaymentDetail-primary-id" value="0" />
                            <div id="div-show-txt-gateWayPaymentDetail-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundationcore.gate_way_payment_details.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-gateWayPaymentDetail-primary-id">
                                <div class="row">
                                    <div class="col-lg-12">
                                    @include('hasob-foundationcore.gate_way_payment_details.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-gateWayPaymentDetail-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-gateWayPaymentDetail-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-gate_way_payment_details').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-gateWayPaymentDetail-modal", function(e) {
        $('#div-gateWayPaymentDetail-modal-error').hide();
        $('#mdl-gateWayPaymentDetail-modal').modal('show');
        $('#frm-gateWayPaymentDetail-modal').trigger("reset");
        $('#txt-gateWayPaymentDetail-primary-id').val(0);

        $('#div-show-txt-gateWayPaymentDetail-primary-id').hide();
        $('#div-edit-txt-gateWayPaymentDetail-primary-id').show();

        $("#spinner-gate_way_payment_details").hide();
        $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-gateWayPaymentDetail-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-gate_way_payment_details').fadeIn(300);
            return;
        }else{
            $('.offline-gate_way_payment_details').fadeOut(300);
        }

        $('#div-gateWayPaymentDetail-modal-error').hide();
        $('#mdl-gateWayPaymentDetail-modal').modal('show');
        $('#frm-gateWayPaymentDetail-modal').trigger("reset");

        $("#spinner-gate_way_payment_details").show();
        $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', true);

        $('#div-show-txt-gateWayPaymentDetail-primary-id').show();
        $('#div-edit-txt-gateWayPaymentDetail-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('tet-att-api.gate_way_payment_details.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-gateWayPaymentDetail-primary-id').val(response.data.id);
            		$('#spn_gateWayPaymentDetail_payable_type').html(response.data.payable_type);
		$('#spn_gateWayPaymentDetail_payable_id').html(response.data.payable_id);
		$('#spn_gateWayPaymentDetail_type').html(response.data.type);
		$('#spn_gateWayPaymentDetail_bank_account_number').html(response.data.bank_account_number);
		$('#spn_gateWayPaymentDetail_bank_name').html(response.data.bank_name);
		$('#spn_gateWayPaymentDetail_bank_sort_code').html(response.data.bank_sort_code);
		$('#spn_gateWayPaymentDetail_account_gateway_code').html(response.data.account_gateway_code);
		$('#spn_gateWayPaymentDetail_status').html(response.data.status);
		$('#spn_gateWayPaymentDetail_currency').html(response.data.currency);


            $("#spinner-gate_way_payment_details").hide();
            $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-gateWayPaymentDetail-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-gateWayPaymentDetail-modal-error').hide();
        $('#mdl-gateWayPaymentDetail-modal').modal('show');
        $('#frm-gateWayPaymentDetail-modal').trigger("reset");

        $("#spinner-gate_way_payment_details").show();
        $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', true);

        $('#div-show-txt-gateWayPaymentDetail-primary-id').hide();
        $('#div-edit-txt-gateWayPaymentDetail-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('tet-att-api.gate_way_payment_details.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-gateWayPaymentDetail-primary-id').val(response.data.id);
            		$('#payable_type').val(response.data.payable_type);
		$('#payable_id').val(response.data.payable_id);
		$('#type').val(response.data.type);
		$('#bank_account_number').val(response.data.bank_account_number);
		$('#bank_name').val(response.data.bank_name);
		$('#bank_sort_code').val(response.data.bank_sort_code);
		$('#account_gateway_code').val(response.data.account_gateway_code);
		$('#status').val(response.data.status);
		$('#currency').val(response.data.currency);


            $("#spinner-gate_way_payment_details").hide();
            $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-gateWayPaymentDetail-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-gate_way_payment_details').fadeIn(300);
            return;
        }else{
            $('.offline-gate_way_payment_details').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this GateWayPaymentDetail?",
                text: "You will not be able to recover this GateWayPaymentDetail if deleted.",
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
                        title: '<div id="spinner-gate_way_payment_details" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
                        text: 'Deleting GateWayPaymentDetail.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        html: true
                    }) 
                                        
                    let endPointUrl = "{{ route('tet-att-api.gate_way_payment_details.destroy','') }}/"+itemId;

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
                                        text: "GateWayPaymentDetail deleted successfully",
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
    $('#btn-save-mdl-gateWayPaymentDetail-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-gate_way_payment_details').fadeIn(300);
            return;
        }else{
            $('.offline-gate_way_payment_details').fadeOut(300);
        }

        $("#spinner-gate_way_payment_details").show();
        $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('tet-att-api.gate_way_payment_details.store') }}";
        let primaryId = $('#txt-gateWayPaymentDetail-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('tet-att-api.gate_way_payment_details.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		if ($('#payable_type').length){	formData.append('payable_type',$('#payable_type').val());	}
		if ($('#payable_id').length){	formData.append('payable_id',$('#payable_id').val());	}
		if ($('#type').length){	formData.append('type',$('#type').val());	}
		if ($('#bank_account_number').length){	formData.append('bank_account_number',$('#bank_account_number').val());	}
		if ($('#bank_name').length){	formData.append('bank_name',$('#bank_name').val());	}
		if ($('#bank_sort_code').length){	formData.append('bank_sort_code',$('#bank_sort_code').val());	}
		if ($('#account_gateway_code').length){	formData.append('account_gateway_code',$('#account_gateway_code').val());	}
		if ($('#status').length){	formData.append('status',$('#status').val());	}
		if ($('#currency').length){	formData.append('currency',$('#currency').val());	}


        {{-- 
        swal({
            title: '<div id="spinner-gate_way_payment_details" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Processing...  </span> </div> <br><br> Please wait...',
            text: 'Saving GateWayPaymentDetail',
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
					$('#div-gateWayPaymentDetail-modal-error').html('');
					$('#div-gateWayPaymentDetail-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-gateWayPaymentDetail-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-gateWayPaymentDetail-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-gateWayPaymentDetail-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "GateWayPaymentDetail saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-gate_way_payment_details").hide();
                $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-gate_way_payment_details").hide();
                $("#div-save-mdl-gateWayPaymentDetail-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

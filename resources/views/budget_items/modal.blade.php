

<div class="modal fade" id="mdl-budgetItem-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-budgetItem-modal-title" class="modal-title">Budget Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-budgetItem-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-budgetItem-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-budget_items">You are currently offline</span></div>

                            <div id="spinner-budget_items" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-budgetItem-primary-id" value="0" />
                            <div id="div-show-txt-budgetItem-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.budget_items.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-budgetItem-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.budget_items.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-budgetItem-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-budgetItem-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-budget_items').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-budgetItem-modal", function(e) {
        $('#div-budgetItem-modal-error').hide();
        $('#mdl-budgetItem-modal').modal('show');
        $('#frm-budgetItem-modal').trigger("reset");
        $('#txt-budgetItem-primary-id').val(0);

        $('#div-show-txt-budgetItem-primary-id').hide();
        $('#div-edit-txt-budgetItem-primary-id').show();

        $("#spinner-budget_items").hide();
        $("#div-save-mdl-budgetItem-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-budgetItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budget_items').fadeIn(300);
            return;
        }else{
            $('.offline-budget_items').fadeOut(300);
        }

        $('#div-budgetItem-modal-error').hide();
        $('#mdl-budgetItem-modal').modal('show');
        $('#frm-budgetItem-modal').trigger("reset");

        $("#spinner-budget_items").show();
        $("#div-save-mdl-budgetItem-modal").attr('disabled', true);

        $('#div-show-txt-budgetItem-primary-id').show();
        $('#div-edit-txt-budgetItem-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.budget_items.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-budgetItem-primary-id').val(response.data.id);
            		$('#spn_budgetItem_title').html(response.data.title);
		$('#spn_budgetItem_code').html(response.data.code);
		$('#spn_budgetItem_group').html(response.data.group);
		$('#spn_budgetItem_type').html(response.data.type);
		$('#spn_budgetItem_location').html(response.data.location);
		$('#spn_budgetItem_description').html(response.data.description);
		$('#spn_budgetItem_allocated_amount').html(response.data.allocated_amount);


            $("#spinner-budget_items").hide();
            $("#div-save-mdl-budgetItem-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-budgetItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-budgetItem-modal-error').hide();
        $('#mdl-budgetItem-modal').modal('show');
        $('#frm-budgetItem-modal').trigger("reset");

        $("#spinner-budget_items").show();
        $("#div-save-mdl-budgetItem-modal").attr('disabled', true);

        $('#div-show-txt-budgetItem-primary-id').hide();
        $('#div-edit-txt-budgetItem-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.budget_items.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-budgetItem-primary-id').val(response.data.id);
            		$('#title').val(response.data.title);
		$('#code').val(response.data.code);
		$('#group').val(response.data.group);
		$('#type').val(response.data.type);
		$('#location').val(response.data.location);
		$('#description').val(response.data.description);
		$('#allocated_amount').val(response.data.allocated_amount);


            $("#spinner-budget_items").hide();
            $("#div-save-mdl-budgetItem-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-budgetItem-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budget_items').fadeIn(300);
            return;
        }else{
            $('.offline-budget_items').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this BudgetItem?",
                text: "You will not be able to recover this BudgetItem if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.budget_items.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "BudgetItem deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "BudgetItem deleted successfully",
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
    $('#btn-save-mdl-budgetItem-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budget_items').fadeIn(300);
            return;
        }else{
            $('.offline-budget_items').fadeOut(300);
        }

        $("#spinner-budget_items").show();
        $("#div-save-mdl-budgetItem-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.budget_items.store') }}";
        let primaryId = $('#txt-budgetItem-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.budget_items.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('title', $('#title').val());
		formData.append('code', $('#code').val());
		formData.append('group', $('#group').val());
		formData.append('type', $('#type').val());
		formData.append('location', $('#location').val());
		formData.append('description', $('#description').val());
		formData.append('allocated_amount', $('#allocated_amount').val());


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
					$('#div-budgetItem-modal-error').html('');
					$('#div-budgetItem-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-budgetItem-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-budgetItem-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-budgetItem-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "BudgetItem saved successfully",
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

                $("#spinner-budget_items").hide();
                $("#div-save-mdl-budgetItem-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-budget_items").hide();
                $("#div-save-mdl-budgetItem-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

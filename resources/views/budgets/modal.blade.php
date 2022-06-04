

<div class="modal fade" id="mdl-budget-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-budget-modal-title" class="modal-title">Budget</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-budget-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-budget-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-budgets">You are currently offline</span></div>

                            <div id="spinner-budgets" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-budget-primary-id" value="0" />
                            <div id="div-show-txt-budget-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('hasob-lab-manager-module::pages.budgets.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-budget-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('hasob-lab-manager-module::pages.budgets.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-budget-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-budget-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-budgets').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-budget-modal", function(e) {
        $('#div-budget-modal-error').hide();
        $('#mdl-budget-modal').modal('show');
        $('#frm-budget-modal').trigger("reset");
        $('#txt-budget-primary-id').val(0);

        $('#div-show-txt-budget-primary-id').hide();
        $('#div-edit-txt-budget-primary-id').show();

        $("#spinner-budgets").hide();
        $("#div-save-mdl-budget-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-budget-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budgets').fadeIn(300);
            return;
        }else{
            $('.offline-budgets').fadeOut(300);
        }

        $('#div-budget-modal-error').hide();
        $('#mdl-budget-modal').modal('show');
        $('#frm-budget-modal').trigger("reset");

        $("#spinner-budgets").show();
        $("#div-save-mdl-budget-modal").attr('disabled', true);

        $('#div-show-txt-budget-primary-id').show();
        $('#div-edit-txt-budget-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.budgets.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-budget-primary-id').val(response.data.id);
            		$('#spn_budget_name').html(response.data.name);
		$('#spn_budget_code').html(response.data.code);
		$('#spn_budget_group').html(response.data.group);
		$('#spn_budget_type').html(response.data.type);


            $("#spinner-budgets").hide();
            $("#div-save-mdl-budget-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-budget-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-budget-modal-error').hide();
        $('#mdl-budget-modal').modal('show');
        $('#frm-budget-modal').trigger("reset");

        $("#spinner-budgets").show();
        $("#div-save-mdl-budget-modal").attr('disabled', true);

        $('#div-show-txt-budget-primary-id').hide();
        $('#div-edit-txt-budget-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('lm-api.budgets.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-budget-primary-id').val(response.data.id);
            		$('#name').val(response.data.name);
		$('#code').val(response.data.code);
		$('#group').val(response.data.group);
		$('#type').val(response.data.type);


            $("#spinner-budgets").hide();
            $("#div-save-mdl-budget-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-budget-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budgets').fadeIn(300);
            return;
        }else{
            $('.offline-budgets').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Budget?",
                text: "You will not be able to recover this Budget if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('lm-api.budgets.destroy','') }}/"+itemId;

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
                                //swal("Deleted", "Budget deleted successfully.", "success");
                                swal({
                                        title: "Deleted",
                                        text: "Budget deleted successfully",
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
    $('#btn-save-mdl-budget-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-budgets').fadeIn(300);
            return;
        }else{
            $('.offline-budgets').fadeOut(300);
        }

        $("#spinner-budgets").show();
        $("#div-save-mdl-budget-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('lm-api.budgets.store') }}";
        let primaryId = $('#txt-budget-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('lm-api.budgets.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        // formData.append('', $('#').val());
        		formData.append('name', $('#name').val());
		formData.append('code', $('#code').val());
		formData.append('group', $('#group').val());
		formData.append('type', $('#type').val());


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
					$('#div-budget-modal-error').html('');
					$('#div-budget-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-budget-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-budget-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-budget-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Budget saved successfully",
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

                $("#spinner-budgets").hide();
                $("#div-save-mdl-budget-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-budgets").hide();
                $("#div-save-mdl-budget-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

@if (isset($disabled_item) && $disabled_item!=null)
    <a  href="#" 
        title="Disable" 
        id="btn-{{$control_id}}"
        class="btn-disable-selector me-2"
        data-toggle="tooltip" 
        data-val-id="{{$disabled_item->id}}"
        data-val-type="{{get_class($disabled_item)}}">
            <i class="fa fa-ban text-warning small"></i>
    </a>
@endif

@once

    <div class="modal fade" id="mdl-disable-selector-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 id="lbl-disable-selector-modal-title" class="modal-title">Disable</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="disabled_item_id" id="disabled_item_id" value="0">
                <div class="modal-body">
                    <div id="div-disable-selector-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-disable-selector-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">
                                @csrf

                                <div id="spinner-disable-selector" class="">
                                    <div class="loader" id="loader-disable-selector"></div>
                                </div>

                                <p id="disable-selector-status" class="text-danger"></p>
                                <input id="disable-selector-item-id" type="hidden" value="" />
                                <input id="disable-selector-item-type" type="hidden" value="" />

                                <div class="mb-3 form-check">
                                    <label for="cbx_is_disabled" id="label_status" class="col-sm-3 form-check-label" >Disabled</label>
                                    <input class='form-check-input' type="checkbox" id="cbx_is_disabled" name="cbx_is_disabled" value="0" />
                                </div>

                                <div class="mb-3">
                                    <label for="disable_reason" class="col-sm-12 form-label">Reason</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="disable_reason" name="disable_reason" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-disable-selector-modal" value="add">
                        <span class="spinner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('spinner').hide();
            // let is_disabled = true;
            $(document).on('click', ".btn-disable-selector", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});
                
                
                let itemId = $(this).attr('data-val-id');
                let itemType = $(this).attr('data-val-type');
                $('#disable-selector-item-id').val(itemId);
                $('#disable-selector-item-type').val(itemType);
                console.log($('#cbx_is_disabled').val())

                //Implement

                 $.get("{{ route('fc-api.disabled_items.index','') }}?disable_id="+itemId+"&disable_type="+itemType).done(function(response) {
                   if (response.data){
                       if (Object.keys(response.data) > 0){
                           //disabled
                           Object.keys(response.data).map(element =>{
                                $('#disabled_item_id').val(response.data[element].id);
                                if(response.data[element].is_disabled == true){
                                    $('#disable-selector-status').html("Disabled");
                                    $('#cbx_is_disabled').val("1")
                                    $('#label_status').html('Enable')
                                }else{
                                    $('#disable-selector-status').html("Enabled");
                                    $('#cbx_is_disabled').val("0")
                                    $('#label_status').html('Disable')
                                }
                                
                           });
                        }else{
                            console.log("no");
                            $('#disable-selector-status').html("Enabled");
                            $('#cbx_is_disabled').val("0")
                            $('#label_status').html('Disable')
                         
                       } 
                   }
               }).fail(function(error) {
                    console.log(error);// or whatever
                });

                $('#mdl-disable-selector-modal').modal('show');
                $('#frm-disable-selector-modal').trigger("reset");
            });

            //Save details
            $('#btn-save-mdl-disable-selector-modal').click(function(e) {
                let itemId = $(this).attr('data-val-id');
                let itemType = $(this).attr('data-val-type');
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                $(".spinner").show();
                $("#btn-save-mdl-disable-selector-modal").prop('disabled', true);
                
                

                let actionType = "POST"
                let endPointUrl = "{{ route('fc-api.disabled_items.store') }}";
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', "POST");
                @if (isset($organization) && $organization != null)
                            formData.append('organization_id',
                                '{{ $organization->id }}');
                @endif
            
               if($('#cbx_is_disabled').is(':checked')){
                    if($('#cbx_is_disabled').val() == "1"){
                     formData.append('is_disabled', "0");
                    }else{
                            formData.append('is_disabled', "1");
                    }
               }else{
                   formData.append('is_disabled', $('#cbx_is_disabled').val());
               }  
               let disabledId = $('#disabled_item_id').val();
               console.log(disabledId);
               if(disabledId != "0"){
                    formData.append('_method',"PUT");
                    formData.append('id',disabledId);
                    endPointUrl = "{{ route('fc-api.disabled_items.update','') }}/"+disabledId
               }
                formData.append('disable_id', $('#disable-selector-item-id').val());
                formData.append('disable_type', $('#disable-selector-item-type').val()); //String.raw`{{ get_class($disabled_item) }}`);
                formData.append('disable_reason', $('#disable_reason').val());

                $.ajax({
                    url: endPointUrl,
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        if (result.errors) {
                            //implement
                             $('#div-disable-selector-modal-error').html('');
                            $('#div-disable-selector-modal-error').show();
                            $.each(result.errors, function(key, value) {
                                $('#div-disable-selector-modal-error').append(
                                    '<li class="">' + value + '</li>'
                                );
                            });
                        } else {
                            swal({
                                title: "Saved",
                                text: "Saved successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })

                            setTimeout(function() {
                              location.reload(true);
                            }, 1000);
                        }
                        $(".spinner").hide();
                        $("#btn-save-mdl-disable-selector-modal").prop('disabled', false);
                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error",
                                    "Oops an error occurred. Please try again.",
                                    "error");

                                $(".spinner").hide();
                                $("#btn-save-mdl-disable-selector-modal").prop('disabled', false);
                    }
                });
            });


        });
    </script>
    @endpush

@endonce
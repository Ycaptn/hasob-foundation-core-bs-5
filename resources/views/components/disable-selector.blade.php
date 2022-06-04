@if (isset($disabled_item) && $disabled_item!=null)
    <a  href="#" 
        title="Disable" 
        id="btn-{{$control_id}}"
        class="btn-disable-selector me-1"
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
                                    <label for="cbx_is_disabled" class="col-sm-3 form-check-label">Disabled</label>
                                    <input class='form-check-input' type="checkbox" id="cbx_is_disabled" name="cbx_is_disabled" />
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
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-disable-selector-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $(document).on('click', ".btn-disable-selector", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});

                let itemId = $(this).attr('data-val-id');
                let itemType = $(this).attr('data-val-type');
                $('#disable-selector-item-id').val(itemId);
                $('#disable-selector-item-type').val(itemType);

                //Implement
                //If disabled, show enabled checkbox
                //If enabled, show disabled checkbox and text area.
                $('#disable-selector-status').html("Enabled");

                //Get disable status
                $.get("{{ route('fc-api.disabled_items.index','') }}?is_current=1&disable_id="+itemId+"&disable_type="+itemType).done(function(response) {
                    if (response.data){
                        if (response.data.length > 0 && response.data[0].is_disabled==true){
                            //disabled
                            $('#disable-selector-status').html("Disabled");
                        } 
                    }
                });

                $('#mdl-disable-selector-modal').modal('show');
                $('#frm-disable-selector-modal').trigger("reset");
            });

            //Save details
            $('#btn-save-mdl-disable-selector-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', "POST");
                formData.append('is_disabled', true);
                formData.append('disable_id', '{{$disabled_item->id}}');
                formData.append('disable_type', $('#disable-selector-item-type').val()); //String.raw`{{ get_class($disabled_item) }}`);
                formData.append('disable_reason', $('#disable_reason').val());

                $.ajax({
                    url: "{{ route('fc-api.disabled_items.store') }}",
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            //implement
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
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


        });
    </script>
    @endpush

@endonce
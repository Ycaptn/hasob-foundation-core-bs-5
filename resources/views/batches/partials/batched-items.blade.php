<div>
    <strong> Batched Items </strong>
    <div id="div-remove-batch-item-modal-error" class="alert alert-danger" role="alert"></div>
    <div class="row">
        @foreach ($batched_items as $batched_item)
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $batched_item['value'] }}"
                        name="cbx_batched_items" id="{{ $batched_item['value'] }}-cbx_batched_items">
                    <label class="form-check-label" for="{{ $batched_item['value'] }}-cbx_batched_items">
                        {{ $batched_item['key'] }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <button class="btn btn-warning btn-save-remove-batch-item mx-2">Remove Selected Batch Items</button>
        <button class="btn btn-danger btn-save-move-batch-items mx-2">Remove Selection to Another Batch</button>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div-remove-batch-item-modal-error').hide();
            $('.btn-save-remove-batch-item').click(function(e) {
                e.preventDefault();

                let selected_ids = [];
                $("input[name='cbx_batched_items']:checked").each(function(item) {
                    selected_ids.push($(this).val());
                });

                if (selected_ids.length === 0) {

                    swal({
                        title: "Warning",
                        text: "No Batch Item Selected for Removal",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {

                    });

                } else {


                    swal({
                        title: "Are you sure you want to remove the selected items to this this batch?",
                        text: "The selected batch items is can still be re-added when removed",
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
                                title: '<div id="spinner-remove-batchable-items" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Loading...  </span> </div> <br><br>Deleting...',
                                text: 'Please wait while selected is been added to batch.<br><br> Do not refresh this page! ',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                html: true
                            });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });
                            $('.btn-save-remove-batch-item span').show()
                            $('.btn-save-remove-batch-item').attr('disabled', true)
                            let actionType = "POST";
                            let endPointUrl =
                                "{{ route('fc-api.batch.remove-batch-item', $batch->id) }}";
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('batch_id', "{{ $batch->id }}");
                            formData.append('batchable_type', String.raw`{{ $batch->batchable_type }}`);
                            formData.append("batchable_id", selected_ids);
                            // formData.append('batchable_id', $('#sel_batched_id').val());
                            formData.append('_method', actionType);
                            @if (isset($organization) && $organization != null)
                                formData.append('organization_id', '{{ $organization->id }}');
                            @endif

                            $.ajax({
                                url: endPointUrl,
                                type: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.errors) {
                                        $('#div-remove-batch-item-modal-error').html(
                                            '');
                                        $('#div-remove-batch-item-modal-error').show();

                                        $.each(result.errors, function(key, value) {
                                            $('#div-remove-batch-item-modal-error')
                                                .append(
                                                    '<li class="">' +
                                                    value + '</li>');
                                        });
                                    } else {
                                        $('#div-remove-batch-item-modal-error').hide();
                                        window.setTimeout(function() {

                                            $('#div-remove-batch-item-modal-error')
                                                .hide();

                                            swal({
                                                title: "Saved",
                                                text: "Batch items removed added successfully",
                                                type: "success",
                                                showCancelButton: false,
                                                closeOnConfirm: false,
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "OK",
                                                closeOnConfirm: false
                                            }, function() {
                                                location.reload(true);
                                            });

                                        }, 20);
                                    }

                                    $('.btn-save-remove-batch-item span').hide()
                                    $('.btn-save-remove-batch-item').attr('disabled',
                                        false)
                                },
                                error: function(data) {
                                    console.log(data);
                                    $('.btn-save-remove-batch-item').attr('disabled',
                                        false)
                                    $('.btn-save-remove-batch-item span').hide()
                                }
                            });
                        }
                    });

                }

            })



        })
    </script>
@endpush

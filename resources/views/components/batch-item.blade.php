@if ($batchable != null)
    <button id="add-batch-item" type="button" class="btn btn-sm btn-primary">Add to Batch</button>
    <div class="modal fade" id="batch-item-modal" tabindex="-1" role="dialog" aria-labelledby="batch-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="batch-item-modal-label">Add to Batch</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="error_div_batch_item" class="alert alert-danger" role="alert">
                        <span id="error_msg_batch"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            @if($batchable->is_batched() == true)
                                <div class="my-1 text-success text-center">
                                    Item already added to a batch
                                </div>
                            @endif
                            <div class="text-center" id="div-batch_preview_message">
                                <span class="text-danger text-center"> Select a Batch to preview content</span>
                            </div>
                            <div id="batch_preview_spinner">
                                <span id="spinner" class="spinner-border spinner-border-lg" role="status"
                                aria-hidden="true"></span>
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            
                            <div id="div-batch_item_preview">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <form class="form-horizontal" id="batch-form" method="post" enctype="multipart/form-data">
                                {!! csrf_field() !!}

                                <div id="div_batch_name" class="mb-3">
                                    <label class="form-label">Batch</label>
                                    <div class="col-xs-9">
                                        <select name="batch_id" id="sel_batch_id" class="form-select">
                                            <option value="">--Select a batch to preview --</option>
                                            @foreach ($batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <button type="button" class="btn btn-primary my-3" id="btn-add-batch-item"
                                        value="add">
                                        <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Loading...</span> Add to batch</button>
                                    <button type="button" class="btn btn-danger my-3" id="btn-remove-batch-item"
                                        value="add">
                                        <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span class="visually-hidden">Loading...</span> Remove Item from Batch</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#btn-add-batch-item').hide();
                $('#error_div_batch_item').hide()
                $('#batch_preview_spinner').hide()
                $('#btn-add-batch-item span').hide();
                $('#btn-remove-batch-item').hide();
                $('#btn-remove-batch-item span').hide();
                $('#add-batch-item').click(function() {
                    $('#error_div_batch').hide();
                    $('#batch-item-form').trigger("reset");
                    $('#batch-item-modal').modal('show');
                });

                $('#btn-add-batch-item').click(function(e) {
                    e.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    e.preventDefault();
                    $('#error_div_batch').html('');
                    $('#btn-add-batch-item span').show();
                    $('#btn-add-batch-item').attr('disabled', true);
                    var formData = new FormData();
                    @if (isset($organization))
                        formData.append('organization_id', "{{ $organization->id }}")
                    @endif
                    formData.append('batch_id', $('#sel_batch_id').val());
                    formData.append('batchable_type', String.raw`{{ get_class($batchable) }}`)
                    formData.append('batchable_id', "{{ $batchable->id }}")
                    formData.append('creator_user_id', "{{ auth()->user()->id }}")


                    $.ajax({
                        url: "{{ route('fc-api.batch_items.store') }}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)
                            if (response != null && response.errors) {
                                $('#error_div_batch_item').show();
                                $.each(response.errors, function(key, value) {
                                    $('#error_div_batch_item')
                                        .append('<li class="">' + value[0] + '</li>');

                                })

                            } else {
                                $('#error_div_batch_item').hide();
                                swal({
                                    title: "Saved",
                                    text: "Batch Item created successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                                window.setTimeout(function() {
                                    location.reload(true);
                                }, 1000);
                            }
                            $('#btn-add-batch-item').attr('disabled', false);
                            $('#btn-add-batch-item span').hide();
                        },
                        error: function(response) {
                            $('#btn-add-batch-item').attr('disabled', false);
                            $('#btn-add-batch-item span').hide();
                            $('#btn-add-batch-item').attr('disabled', false);
                            $('#btn-add-batch-item span').hide();
                        }
                    });

                })

                $('#btn-remove-batch-item').click(function(e) {
                    e.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    e.preventDefault();
                    $('#error_div_batch').html('');
                    $('#btn-remove-batch-item span').show();
                    $('#btn-remove-batch-item').attr('disabled', true);
                    var formData = new FormData();
                    @if (isset($organization))
                        formData.append('organization_id', "{{ $organization->id }}")
                    @endif
                    let batch_id = $('#sel_batch_id').val();
                    formData.append('batch_id', $('#sel_batch_id').val());
                    formData.append('batchable_type', String.raw`{{ get_class($batchable) }}`)
                    formData.append('batchable_id', "{{ $batchable->id }}")
                    formData.append('creator_user_id', "{{ auth()->user()->id }}")


                    $.ajax({
                        url: "{{ route('fc-api.batch.remove-batch-item','') }}/"+batch_id,
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)
                            if (response != null && response.errors) {
                                $('#error_div_batch_item').show();
                                $.each(response.errors, function(key, value) {
                                    $('#error_div_batch_item')
                                        .append('<li class="">' + value + '</li>');

                                })

                            } else {
                                $('#error_div_batch_item').hide();
                                swal({
                                    title: "Saved",
                                    text: "Batch Item removed successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                                window.setTimeout(function() {
                                    location.reload(true);
                                }, 1000);
                            }
                            $('#btn-remove-batch-item').attr('disabled', false);
                            $('#btn-remove-batch-item span').hide();
                        },
                        error: function(response) {
                            $('#btn-remove-batch-item').attr('disabled', false);
                            $('#btn-remove-batch-item span').hide();
                            $('#btn-remove-batch-item').attr('disabled', false);
                            $('#btn-remove-batch-item span').hide();
                        }
                    });

                })

                $('#sel_batch_id').change(function(e) {
                    e.preventDefault()
                    let batch_id = $('#sel_batch_id').val();
                    $('#div-batch_item_preview').empty()
                    $('#btn-add-batch-item').hide();
                    $('#btn-remove-batch-item').hide();
                    $('#batch_preview_spinner').show()
                    if (batch_id != '') {
                        let formData = new FormData();
                        formData.append('_token',$('input[name="_token"]').val())
                        formData.append('_method',"POST")
                        formData.append('batch_id', batch_id)
                        formData.append('batchable_type', String.raw`{{ get_class($batchable) }}`)
                        formData.append('batchable_id', "{{ $batchable->id }}")
                        $.ajax({
                            url: "{{ route('fc-api.batch.preview-batch-item', '') }}/" + batch_id,
                            type: 'POST',
                            cache: false,
                            processData: false,
                            data: formData,
                            contentType: false,
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);                                $('#div-batch_preview_message').empty()
                                $('#div-batch_item_preview').append(response.data.content);
                                $('#div-batch_preview_message').append(
                                    `<span class="text-success text-center"> Previewing ${response.data.batch_details.name} content</span>`
                                    )
                                if (response.data.has_been_batched == true) {
                                    $('#btn-add-batch-item').hide();
                                    $('#btn-remove-batch-item').show();
                                } else {
                                    $('#btn-add-batch-item').show();
                                    $('#btn-remove-batch-item').hide();
                                }
                                $('#batch_preview_spinner').hide()
                            },
                            error: function(response) {
                                $('#div-batch_preview_message').empty()
                                $('#batch_preview_spinner').hide()
                                $('#div-batch_preview_message').append(
                                    `<span class="text-danger text-center"> Select a Batch to preview content</span>`
                                    )
                                $('#div-batch_item_preview').append(
                                    "<div>something went wrong</div>");
                                $('#btn-add-batch-item').hide();
                            }
                        });
                    } else {
                        $('#btn-add-batch-item').hide();
                        $('#btn-remove-batch-item').hide();
                    }
                });


            });
        </script>
    @endpush
@endif

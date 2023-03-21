@if ($batchable != null)
    <button id="create-batch" type="button" class="btn btn-sm btn-primary">Create Batch</button>
    <div class="modal fade" id="batch-modal" tabindex="-1" role="dialog" aria-labelledby="batch-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="batch-modal-label">Create Batch</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="error_div_batch" class="alert alert-danger" role="alert">
                        <span id="error_msg_batch"></span>
                    </div>

                    <form class="form-horizontal" id="batch-form" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <div id="div_batch_name" class="mb-3">
                            <label class="form-label">Batch Name</label>
                            <div class="col-xs-9">
                                <div class="{{ $errors->has('batch_name') ? ' has-error' : '' }}">
                                    <input type='text' class="form-control" id="batch_name" name="batch_name"
                                        value="{{ old('batch_name') }}" required />
                                </div>
                            </div>
                        </div>

                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-add-batch" value="add">
                        <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span> Save Batch</button>
                </div>
            </div>
        </div>
    </div>


    @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#btn-add-batch span').hide();
                $('#create-batch').click(function() {
                    $('#error_div_batch').hide();
                    $('#batch-form').trigger("reset");
                    $('#batch-modal').modal('show');
                });

                $("#btn-add-batch").click(function(e) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    e.preventDefault();
                    $('#error_div_batch').html('');
                    $('#btn-add-batch span').show();
                    $('#btn-add-batch').attr('disabled', true);
                    var formData = new FormData();
                    @if(isset($organization))
                        formData.append('organization_id',"{{$organization->id}}")
                    @endif
                    formData.append('name', $('#batch_name').val());
                    formData.append('status', "new");
                    formData.append('batchable_type', String.raw`{{ get_class($batchable) }}`)
                    formData.append('creator_user_id', "{{auth()->user()->id}}")


                    $.ajax({
                        url: "{{ route('fc-api.batches.store') }}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)
                            if (response != null && response.errors) {
                                $('#error_div_batch').show();
                                    $.each(response.errors, function(key, value) {
                                        $('#error_div_batch')
                                            .append('<li class="">' + value[0]+ '</li>');

                                    })

                            } else {
                                $('#error_div_batch').hide();
                                swal({
                                    title: "Saved",
                                    text: "Batch created successfully",
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
                            $('#btn-add-batch').attr('disabled', false);
                            $('#btn-add-batch span').hide();
                        },
                        error: function(response) {
                            $('#btn-add-batch').attr('disabled', false);
                            $('#btn-add-batch span').hide();
                            $('#btn-add-batch').attr('disabled', false);
                            $('#btn-add-batch span').hide();
                        }
                    });
                });

            });
        </script>
    @endpush
@endif

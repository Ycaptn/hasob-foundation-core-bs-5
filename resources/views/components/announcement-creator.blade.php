@if ($announceable != null)
    <button id='btn-show-announcement-upload' type="button" class="btn btn-sm btn-primary">{{ $label  }}</button>
    <div class="modal fade" id="announcement-modal" tabindex="-1" role="dialog" aria-labelledby="announcement-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="announcement-modal-label">Announcement</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="error_div_announcement" class="alert alert-danger" role="alert">
                        <span id="error_msg_announcement"></span>
                    </div>

                    <form class="form-horizontal" id="upload-form" method="post" enctype="multipart/form-data">
                        @csrf

                        <div id="div_announcement_title" class="mb-3">
                            <label class="form-label">Title</label>
                            <div class="col-xs-9">
                                <div class="{{ $errors->has('announcement_title') ? ' has-error' : '' }}">
                                    <input type='text' class="form-control" id="announcement_title"
                                        name="announcement_title" value="{{ old('announcement_title') }}" required />
                                </div>
                            </div>
                        </div>

                        <div id="div_announcement_end_date" class="mb-3">
                            <label class="form-label">End Date</label>
                            <div class="col-xs-9">
                                <div class="{{ $errors->has('announcement_end_date') ? ' has-error' : '' }}">
                                    <input type='date' class="form-control" id="announcement_end_date"
                                        name="announcement_end_date" required />
                                </div>
                            </div>
                        </div>

                        <div id="div_announcement_description" class="mb-3">
                            <label class="form-label">Description</label>
                            <div class="col-sm-12">
                                <div class="{{ $errors->has('announcement_description') ? ' has-error' : '' }}">
                                    <textarea class="form-control" id="announcement_description" name="announcement_description" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-add-announcement" value="add">
                        <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>Upload
                    </button>
                </div>
            </div>
        </div>
    </div>


    @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#btn-add-announcement span').hide();
                $('#btn-show-announcement-upload').click(function() {
                    $('#error_div_announcement').hide();
                    $('#upload-form').trigger("reset");
                    $('#announcement-modal').modal('show');
                });

                $("#btn-add-announcement").click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                  
                    $('#btn-add-announcement span').show();
                    $('#btn-add-announcement').attr('disabled', true);
                    var formData = new FormData();

                    console.log('first', String.raw`{{ get_class($announceable) }}`);

                    options = JSON.stringify({
                        'headline': $('#announcement_title').val(),
                        'end_date': $('#announcement_end_date').val(),
                        'content': $('#announcement_description').val(),
                        'announceable_id': '{{ $announceable->id }}',
                        'announceable_type': String.raw`{{ get_class($announceable) }}`,
                    });
                    formData.append('options', options);

                    $.ajax({
                        url: "{{ route('fc-api.announceable.store') }}",
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(data) {

                            if (data != null && data.status == 'fail') {
                                $('#error_div_announcement').show();
                                if (data.response != null) {
                                    for (x in data.response) {
                                        if ($.isArray(data.response[x])) {
                                            $('#error_msg_announcement').html(
                                                '<strong>Errors</strong><br/>' + data.response[
                                                    x].join('<br/>'));
                                        } else {
                                            $('#btn-add-announcement span').hide();
                                            $('#btn-add-announcement').attr('disabled', false);
                                            $('#error_msg_announcement').html(
                                                '<strong>Errors</strong><br/>' + data.response[
                                                    x]);
                                        }
                                    }
                                } else {
                                    $('#btn-add-announcement span').hide();
                                    $('#btn-add-announcement').attr('disabled', false);
                                    $('#error_msg_announcement').html(
                                        '<strong>Error</strong><br/>An error has occurred.');
                                }
                            } else if (data != null && data.status == 'ok') {
                                swal({
                                    title: "Saved",
                                    text: "Announcement Created Successfully",
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
                            } else {
                                $('#btn-add-announcement span').hide();
                                $('#btn-add-announcement').attr('disabled', false);
                                $('#error_msg_announcement').html(
                                    '<strong>Error</strong><br/>An error has occurred.');
                            }
                        },
                        error: function(data) {
                            $('#btn-add-announcement span').hide();
                            $('#btn-add-announcement').attr('disabled', false);
                            console.log(data);
                        }
                    });
                });

            });
        </script>
    @endpush
@endif

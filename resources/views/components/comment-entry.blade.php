@if ($commentable != null)
    <div id="comment-form">

        {{ csrf_field() }}
        <input type="hidden" id="comment_primary_id" value="0">
        <div class="input-group">
            <span class="input-group-text"><span class="fa fa-comments"></span></span>
            <input id="{{ isset($comment_tag_id) ? $comment_tag_id : 'comment-text' }}" type="text"
                class="form-control text-sm input-sm" placeholder="Type in your comments and press enter to save comments" />
            <span class='input-group-text' class="btn-send-comment"><a href="#" id="btn-send-comment"
                    class="btn-send-comment"><i class='img-circle img-sm fa fa-paper-plane'
                        style='font-size:25px;padding-top:2px;'></i></a></span>
        </div>

    </div>


    @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#comment_primary_id').hide()
                function showPopup(message) {               
                    alert(message)                
                    return;
                }
                $("#comment-text").on('keypress', function(e) {
                    
                    if (e.which == 13 && $('#comment-text').val().length > 2) {
                        @if(!$usedServiceChecker)
                            showPopup('You need to use this service to comment')
                        @else
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });
                            $('#comment_primary_id').show()
                            e.preventDefault();
                            let spinner = '<div class="loader2" id="loader-1"></div>';
                            var formData = new FormData();
                            if ($('#comment_primary_id').val() == "0") {
                                options = JSON.stringify({
                                    'commentable_id': '{{ $commentable->id }}',
                                    'commentable_type': String.raw`{{ get_class($commentable) }}`,
                                    'comments': $('#comment-text').val(),
                                });
                            } else {
                                options = JSON.stringify({
                                    'commentable_id': '{{ $commentable->id }}',
                                    'commentable_type': String.raw`{{ get_class($commentable) }}`,
                                    'comments': $('#comment-text').val(),
                                    'id': $('#comment_primary_id').val()
                                });
                            }

                            formData.append('options', options);
                            swal({
                                html: true,
                                title: 'Submitting Post Please Wait!',
                                text: spinner,
                                showCancelButton: false,
                                showConfirmButton: false
                            });

                            $.ajax({
                                url: "{{ route('fc.comment-add') }}",
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data) {
                                    swal.close();
                                    if (data != null && data.status == 'fail') {
                                        if (data.response != null) {
                                            swal({
                                                title: "Saved",
                                                text: `Error submitting comments ${data.response}`,
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
                                    } else if (data != null && data.status == 'ok') {
                                        setTimeout(() => {
                                            swal({
                                                title: "Saved",
                                                text: "Comments have been saved",
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
                                        }, 1000);

                                    } else {
                                        swal({
                                            title: "Error",
                                            text: "Error submitting comment",
                                            type: "warning",
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
                                },
                                error: function(data) {
                                    swal.close();
                                    console.log(data);
                                }
                            });
                        @endif
                    }
                });

                $("#btn-send-comment").on('click', function(e) {
                    e.preventDefault();
                    @if(!$usedServiceChecker)
                        showPopup('You need to use this service to comment')
                    @else
                        if ($('#comment-text').val().length > 2) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });
                            $('#comment_primary_id').show()
                            e.preventDefault();
                            let spinner = '<div class="loader2" id="loader-1"></div>';
                            var formData = new FormData();
                            if ($('#comment_primary_id').val() == "0") {
                                options = JSON.stringify({
                                    'commentable_id': '{{ $commentable->id }}',
                                    'commentable_type': String.raw`{{ get_class($commentable) }}`,
                                    'comments': $('#comment-text').val(),
                                });
                            } else {
                                options = JSON.stringify({
                                    'commentable_id': '{{ $commentable->id }}',
                                    'commentable_type': String.raw`{{ get_class($commentable) }}`,
                                    'comments': $('#comment-text').val(),
                                    'id': $('#comment_primary_id').val()
                                });
                            }

                            formData.append('options', options);
                            swal({
                                html: true,
                                title: 'Submitting Post Please Wait!',
                                text: spinner,
                                showCancelButton: false,
                                showConfirmButton: false
                            });

                            $.ajax({
                                url: "{{ route('fc.comment-add') }}",
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                data: formData,
                                success: function(data) {
                                    swal.close();
                                    if (data != null && data.status == 'fail') {
                                        if (data.response != null) {
                                            swal({
                                                title: "Error",
                                                text: `Error submitting comments ${data.response}`,
                                                type: "error",
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
                                    } else if (data != null && data.status == 'ok') {
                                        swal({
                                            title: "Saved",
                                            text: `Comments have been saved`,
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
                                        swal({
                                            title: "Error",
                                            text: `Error submitting comments`,
                                            type: "error",
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
                                },
                                error: function(data) {
                                    swal.close();
                                    console.log(data);
                                }
                            });
                        }
                    @endif
                });

                $(".btn-edit-mdl-comment-modal").on('click', function(e) {
                    e.preventDefault();
                    $('#comment_primary_id').val($(this).attr('data-val'))
                    let id = $(this).attr('data-val');
                    console.log(id);
                    let comment = $('#comment_' + id)[0].innerText;
                    $('#comment-text').val(comment);
                });

            });
        </script>
    @endpush
@endif

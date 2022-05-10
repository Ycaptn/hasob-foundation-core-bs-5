@if ($pageable != null)

    @php
        $pages = $pageable->pages();
    @endphp

    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-grid mb-2">
                        {{-- <a id="{{$control_id}}-add-page" href="javascript:;" class="btn btn-sm btn-primary">+ Add Content Page</a> --}}
                        <button id="btn-{{ $control_id }}-add-new-page" type="button" class="btn btn-sm btn-primary">
                            + Add Content Page
                        </button>
                    </div>
                    <div class="fm-menu">
                        <div id="{{ $control_id }}-page-list" class="list-group list-group-flush">
                            @if ($pages != null && count($pages) > 0)
                                @foreach ($pages as $idx => $page)
                                    <div class="d-flex align-items-center justify-content-between my-1">
                                        <a href="javascript:;" class="list-group-item py-1 page-editor-page-selected"
                                            data-val="{{ $page->id }}">
                                            <i class="bx bx-file me-2"></i><span>{{ $page->page_name }}</span>

                                        </a>
                                        <span>
                                            <a href="javascript:;" class="{{ $control_id }}-delete-page" id=""
                                                data-val="{{ $page->id }}">
                                                <i class="text-danger fa fa-trash fa-fw"></i>
                                            </a>
                                        </span>

                                    </div>
                                @endforeach
                            @else
                                <br /><br />
                                <h6 class="text-center text-danger">No Pages</h6>
                                <br /><br />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card">
                <div id="div-{{ $control_id }}-page-editor" class="card-body">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="div-{{ $control_id }}-page-text-error" class="alert alert-danger"
                                        role="alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-5 mb-2">
                                    <input id="{{ $control_id }}-selected-page-id" type="hidden" value="0" />
                                    {!! Form::text("{$control_id}-page-text-name", null, ['id' => "{$control_id}-page-text-name", 'class' => 'form-control', 'minlength' => 1, 'maxlength' => 1000]) !!}
                                </div>
                                <div class="col-lg-2 mb-2">
                                    <div class="form-check form-switch pt-2">
                                        <input class="form-check-input" type="checkbox"
                                            id="{{ $control_id }}-page-text-is_hidden" checked="">
                                        <label class="form-check-label"
                                            for="{{ $control_id }}-page-text-is_hidden">Hidden</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-2">
                                    <div class="form-check form-switch pt-2">
                                        <input class="form-check-input" type="checkbox"
                                            id="{{ $control_id }}-page-text-is_published" checked="">
                                        <label class="form-check-label"
                                            for="{{ $control_id }}-page-text-is_published">Published</label>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 mb-2 text-end">
                                    <button id="btn-{{$control_id}}-save-page" class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                    <a id="{{$control_id}}-delete-page" href="javascript:;" class="btn btn-sm btn-danger">Delete</a>
                                </div> --}}
                                <div id="div-save-page-{{ $control_id }}" class="col-lg-3 mb-2 text-end">
                                    <button type="button" class="btn btn-primary"
                                        id="btn-{{ $control_id }}-save-page" value="add">
                                        <span class="spinner">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            <span class="visually-hidden">Loading...</span>
                                        </span>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <textarea id="{{ $control_id }}-text-page_contents" name="{{ $control_id }}-text-page_contents"
                            class="summernote"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="{{ $control_id }}-new-page-modal" tabindex="-1" role="dialog" aria-modal="true"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="lbl-{{ $control_id }}-modal-title" class="modal-title">New Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-{{ $control_id }}-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-{{ $control_id }}-modal" role="form" method="POST"
                        enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">

                                @csrf

                                <!-- Name Field -->
                                <div id="div-{{ $control_id }}-name" class="form-group">
                                    <label for="{{ $control_id }}-page-name"
                                        class="col-lg-3 col-form-label">Name</label>
                                    <div class="col-lg-12">
                                        {!! Form::text("{$control_id}-page-name", null, ['id' => "{$control_id}-page-name", 'class' => 'form-control', 'minlength' => 1, 'maxlength' => 1000]) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                {{-- <div class="modal-footer" id="div-save-page-{{$control_id}}-modal">
                    <button type="button" class="btn btn-primary px-5" id="btn-save-page-{{$control_id}}-modal" value="add">Save</button>
                </div> --}}
                <div id="div-save-page-{{ $control_id }}-modal" class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-page-{{ $control_id }}-modal"
                        value="add">
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


    @push('page_css')
        <link rel="stylesheet"
            href="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.css') }}">
    @endpush

    @push('page_scripts')
        <script src="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('.spinner').hide()
                $(window).keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });

                function hide_editor_card() {
                    $("#div-{{ $control_id }}-page-editor").hide();
                    $('#div-{{ $control_id }}-modal-error').html('');
                    $("#div-{{ $control_id }}-page-text-error").hide();
                }

                hide_editor_card();

                $('#{{ $control_id }}-text-page_contents').summernote({
                     height: 200,
                     toolbar: [
                         ['style', ['style']],
                         ['font', ['bold', 'underline', 'clear']],
                         ['fontname', ['fontname']],
                         //['color', ['color']],
                         ['para', ['ul', 'ol', 'paragraph']],
                         ['table', ['table']],
                         ['view', ['codeview']]
                         //['insert', ['link', 'picture']],
                         //['view', ['fullscreen', 'codeview']],
                     ],
                 });

                //Show add new page modal
                $("#btn-{{ $control_id }}-add-new-page").click(function(e) {
                    console.log("here");
                    $('#div-{{ $control_id }}-modal-error').hide();
                    $('#{{ $control_id }}-new-page-modal').modal('show');
                    $('#frm-{{ $control_id }}-modal').trigger("reset");
                });

                //Load page details in editor on click
                $(document).on('click', ".page-editor-page-selected", function(e) {

                    hide_editor_card();

                    let itemId = $(this).attr('data-val');
                    $.get("{{ route('fc-api.pages.show', '') }}/" + itemId).done(function(response) {

                        $("#div-{{ $control_id }}-page-editor").show();

                        $("#{{ $control_id }}-selected-page-id").val(response.data.id);
                        $("#{{ $control_id }}-page-text-name").val(response.data.page_name);
                        $("#{{ $control_id }}-text-page_contents").summernote("code", response.data
                            .content);

                    });

                });

                //New page save button
                $('#btn-save-page-{{ $control_id }}-modal').click(function(e) {

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    $(".spinner").show();
                    $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', true);

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('page_name', $('#{{ $control_id }}-page-name').val());
                    formData.append('creator_user_id', "{{ Auth::id() }}");
                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                    @endif

                    $.ajax({
                        url: "{{ route('fc-api.pages.store') }}",
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {
                            if (result.errors) {
                                $('#div-{{ $control_id }}-modal-error').html('');
                                $('#div-{{ $control_id }}-modal-error').show();
                                $.each(result.errors, function(key, value) {
                                    $('#div-{{ $control_id }}-modal-error').append(
                                        '<li class="">' + value + '</li>');
                                });
                            } else {
                                $('#div-{{ $control_id }}-modal-error').hide();

                                if (result.data != null && result.data.id != null) {
                                    let formData = new FormData();
                                    formData.append('_token', $('input[name="_token"]').val());
                                    formData.append('page_id', result.data.id);
                                    formData.append('pageable_id', '{{ $pageable->id }}');
                                    formData.append('pageable_type', String
                                        .raw`{{ get_class($pageable) }}`);
                                    formData.append('creator_user_id', "{{ Auth::id() }}");
                                    @if (isset($organization) && $organization != null)
                                        formData.append('organization_id',
                                            '{{ $organization->id }}');
                                    @endif

                                    $.ajax({
                                        url: "{{ route('fc-api.pageables.store') }}",
                                        type: "POST",
                                        data: formData,
                                        cache: false,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function(result) {},
                                        error: function(data) {},
                                    });
                                }
                                $('#div-{{ $control_id }}-modal-error').hide();
                                swal({
                                    title: "Saved",
                                    text: "Page saved successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: true
                                }, function() {
                                    $('#{{ $control_id }}-new-page-modal').modal('hide');
                                });
                                window.setTimeout(function() {
                                    location.reload(true);
                                }, 1000);
                            }

                            $(".spinner").hide();
                            $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', false);

                        },
                        error: function(data) {
                            console.log(data);
                            swal("Error", "Oops an error occurred. Please try again.", "error");

                            $(".spinner").hide();
                            $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', false);
                        }
                    });
                });

                //Save details
                $('#btn-{{ $control_id }}-save-page').click(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    let pagePrimaryId = $("#{{ $control_id }}-selected-page-id").val();

                    $(".spinner").show();
                    $("#btn-{{ $control_id }}-save-page").prop('disabled', true);
                    $("#{{ $control_id }}-text-page_contents").prop('disabled', true);
                    console.log(pagePrimaryId);
                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('_method', "PUT");
                    formData.append('id', pagePrimaryId);
                    formData.append('page_name', $('#{{ $control_id }}-page-text-name').val());
                    formData.append('content', $('#{{ $control_id }}-text-page_contents').summernote('code'));
                    //formData.append('is_hidden', $('#{{ $control_id }}-page-text-is_hidden').val());
                    //formData.append('is_published', $('#{{ $control_id }}-page-text-is_published').val());
                    formData.append('creator_user_id', "{{ Auth::id() }}");
                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                    @endif

                    $.ajax({
                        url: "{{ route('fc-api.pages.update', '') }}/" + pagePrimaryId,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {
                            if (result.errors) {
                                $('#div-{{ $control_id }}-page-text-error').html('');
                                $('#div-{{ $control_id }}-page-text-error').show();

                                $.each(result.errors, function(key, value) {
                                    $('#div-{{ $control_id }}-page-text-error').append(
                                        '<li class="">' + value + '</li>');
                                });
                            } else {
                                $('#div-{{ $control_id }}-page-text-error').hide();
                                swal({
                                        title: "Saved",
                                        text: "Page saved successfully",
                                        type: "success",
                                        showCancelButton: false,
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: true
                                    },
                                    function() {}
                                );
                                window.setTimeout(function() {
                                    location.reload(true);
                                }, 1000);
                            }
                            $(".spinner").hide();
                            $("#btn-{{ $control_id }}-save-page").prop('disabled', false);
                            $("#{{ $control_id }}-text-page_contents").prop('disabled', false);

                        },
                        error: function(data) {
                            console.log(data);
                            swal("Error", "Oops an error occurred. Please try again.", "error");
                            $(".spinner").hide();
                            $("#btn-{{ $control_id }}-save-page").prop('disabled', false);
                            $("#{{ $control_id }}-text-page_contents").prop('disabled', false);

                        }
                    });
                });

                //Delete action
                $(document).on('click', ".{{ $control_id }}-delete-page", function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    let itemId = $(this).attr('data-val');
                    swal({
                        title: "Are you sure you want to delete this Content Page?",
                        text: "You will not be able to recover if deleted.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            console.log(itemId)
                            let endPointUrl = "{{ route('fc-api.pageables.destroy', '') }}/" +
                                itemId;

                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('_method', 'DELETE');

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
                                        console.log(result.errors)
                                        swal("Error",
                                            "Oops an error occurred. Please try again.",
                                            "error");
                                    } else {
                                        //swal("Deleted", "SchoolRegistration deleted successfully.", "success");
                                        swal({
                                            title: "Deleted",
                                            text: "Content page deleted successfully",
                                            type: "success",
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false
                                        });
                                        window.setTimeout(function() {
                                            location.reload(true);
                                        }, 1000);
                                    }
                                },
                            });
                        }
                    });

                });

            });
        </script>
    @endpush

@endif

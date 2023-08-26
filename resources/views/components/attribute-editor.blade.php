@if ($artifactable != null)

    @php
        $artifactables = $artifactable->artifacts();
        $artifactable_type = str_replace('\\', '\\\\', get_class($artifactable));
    @endphp


    <div class="row">
        <div class="col-lg-12">
            <div class="d-xl-flex align-items-center">
                <div class="d-flex align-items-center item">
                    <div class="email-toggle-btn">
                        <i class="bx bx-menu"></i>
                    </div>
                    <div class="">
                        <button id="{{ $control_id }}-add-attribute" type="button"
                            class="btn btn-sm btn-primary me-2 ms-2">
                            <i class="bx bx-plus me-0"></i> New Attribute
                        </button>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-white ms-2" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Edit" id="{{ $control_id }}-edit-attribute">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>

                    </div>
                    <div class="">
                        <button type="button" class="btn btn-white ms-2" data-bs-toggle="tooltip" data-bs-html="true"
                            title="Refresh" id="{{ $control_id }}-refresh-attribute">
                            <i class="bx bx-refresh me-0"></i>
                        </button>
                    </div>
                    <div class="">
                        <button type="button" id="{{ $control_id }}-upmove-attribute" class="btn btn-white ms-2"
                            value="up" id="up-vote" data-bs-toggle="tooltip" data-bs-html="true" title="MoveUp">
                            <i class="bx bx-upvote me-0"></i>
                            <span class="spinner-border spinner-border-sm text-primary" id="spinner1" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-white ms-2" value="down"
                            id="{{ $control_id }}-downmove-attribute" data-bs-toggle="tooltip" data-bs-html="true"
                            title="MoveDown">
                            <i class="bx bx-downvote me-0"></i>
                            <span class="spinner-border spinner-border-sm text-primary" id="spinner2" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                    <div class="d-none d-md-flex">
                        <button type="button" class="btn btn-white ms-2" id="{{ $control_id }}-copy-attribute"
                            data-bs-toggle="tooltip" data-bs-html="true" title="Copy">
                            <i class="bx bx-file me-0"></i>
                        </button>
                    </div>
                    <div class="">
                        <button type="button" id="{{ $control_id }}-delete-attribute" class="btn btn-white ms-2"
                            val="" data-bs-toggle="tooltip" data-bs-html="true" title="Delete">
                            <i class="bx bx-trash me-0"></i>
                        </button>
                    </div>
                </div>
                <div class="flex-grow-1 mx-xl-2 my-2 my-xl-0">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent">
                            <i class="bx bx-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search attributes">
                    </div>
                </div>
            </div>
            <div class="">
                @if (count($artifactables) > 0)
                    <div class="">
                        <div class="email-list ps ps--active-y" style="overflow-y:scroll !important;overflow-x:hidden !important;">
                            @foreach ($artifactables->sortBy('display_ordinal') as $item)
                                <div class="model-artifacts-a" id="model_artifact-{{ $item->id }}">
                                    <div class="d-md-flex align-items-center email-message px-3 py-1">
                                        <div class="col-md-3 d-flex align-items-center email-actions">
                                            <input class="form-check-input me-2 model_artifact_attribute"
                                                style="min-width:13px !important;" type="radio" value=""
                                                data-val="{{ $item->id }}" name='radio' />
                                            <p class="mb-0 text-break"><b>{{ $item->key }}</b></p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 attr-val text-break">{{ $item->value }}</p>
                                        </div>
                                        <div class="col-md-2 ms-auto text-center">
                                            <p class="mb-0 email-time text-break">
                                                <!-- {{ $item->created_at->format('Y-m-d H:i:a') }}</p> -->
                                                {{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
</div>
                            @endforeach
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y"
                                style="top: 0px; height: 530px; right: 0px;overflow-y:hidden !important;width:0 !important;">
                                <div class="ps__thumb-y" tabindex="0"
                                    style="top: 0px; height: 233px;overflow-y:hidden !important;"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="">
                        <div class="ps ps--active-y">
                            <h6 class="text-sm-start text-center mt-20" style="margin-top:20px!important;">No Attributes</h6>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="{{ $control_id }}-attribute-modal" tabindex="-1" role="dialog" aria-modal="true"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <input id="{{ $control_id }}-selected-attribute-id" type="hidden" value="0" />
                <div class="modal-header">
                    <h5 id="lbl-{{ $control_id }}-modal-title" class="modal-title">New Attribute</h5>
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
                                <div id="div-{{ $control_id }}-attribute-name" class="form-group">
                                    <label for="{{ $control_id }}-attribute-name"
                                        class="col-lg-3 col-form-label">Name</label>
                                    <div class="col-lg-12">
                                        {!! Form::text("{$control_id}-attribute-name", null, ['id' => "{$control_id}-attribute-name", 'class' => 'form-control', 'minlength' => 1, 'maxlength' => 1000]) !!}
                                    </div>
                                </div>

                                <!-- Value Field -->
                                <div id="div-{{ $control_id }}-attribute-value" class="form-group">
                                    <label for="{{ $control_id }}-attribute-value"
                                        class="col-lg-3 col-form-label"></label>
                                    <div class="col-lg-12">
                                        <textarea placeholder="Attribute Value" id="{{ $control_id }}-attribute-value"
                                            name="{{ $control_id }}-attribute-value" class="form-control"
                                            rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>


                <div class="modal-footer" id="div-save-mdl-{{ $control_id }}-modal">
                    <button type="button" class="btn btn-primary px-5"
                        id="btn-save-mdl-{{ $control_id }}-attributes-save" value="add">Save

                        <span class="spinner-border spinner-border-sm" id="spinner" role="status"
                            aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>

                    </button>
                </div>

            </div>
        </div>
    </div>


    @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#{{ $control_id }}-upmove-attribute').attr('disabled',true);
                $('#{{ $control_id }}-downmove-attribute').attr('disabled',true);
                $(".spinner-border").hide();
                $("#spinner1").hide();
                $("#spinner2").hide();
                $('#btn-save-mdl-{{ $control_id }}-modal').attr('disabled', false);
                $(".alert-danger").hide();
                // $('#frm-{{ $control_id }}-modal').trigger("reset");
                $('.form-horizontal').trigger("reset");
                function hide_attribute_card() {
                    $("#div-{{ $control_id }}-modal-error").html('');
                    $("#div-{{ $control_id }}-modal-error").hide();
                }

                hide_attribute_card();
                
                
                //Show add new attribute modal
                // $('.form-horizontal').trigger("reset");
                $(document).on('click', "#{{ $control_id }}-add-attribute", function(e) {
                    hide_attribute_card();
                    $('.form-horizontal').trigger("reset");
                    
                    
                    $('#{{ $control_id }}-attribute-modal').modal('show');
                    $('.modal-header').find('#lbl-{{ $control_id }}-modal-title').html('<h5>New Attribute</h5>');



                });

                //Load attribute details in editor on click
                $(document).on('click', ".page-editor-page-selected", function(e) {

                    hide_attribute_card();

                    let itemId = $(this).attr('data-val');
                    $.get("{{ route('fc-api.attributes.show', '') }}/" + itemId).done(function(response) {

                        $("#div-{{ $control_id }}-page-editor").show();

                        $("#{{ $control_id }}-selected-attribute-id").val(response.data.id);
                        $("#{{ $control_id }}-page-text-name").val(response.data.page_name);
                        $("#{{ $control_id }}-page_contents").summernote("code", response.data
                            .content);

                    });

                });

                //New attribute save button
                $('#btn-save-mdl-{{ $control_id }}-modal').click(function(e) {
                    $('.form-horizontal').trigger("reset");
                    $('.form-horizontal')[0].reset();
                    e.preventDefault();
                    $("#spinner").show();
                    $('.alert-danger').hide();
                    $('#btn-save-mdl-{{ $control_id }}-modal').attr('disabled', true);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('artifactable_id', '{{ $artifactable->id }}');
                    formData.append('artifactable_type', String.raw`{{ get_class($artifactable) }}`);
                    formData.append('key', $('#{{ $control_id }}-attribute-name').val());
                    formData.append('value', $('#{{ $control_id }}-attribute-value').val());
                    formData.append('creator_user_id', "{{ Auth::id() }}");
                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                    @endif

                    $.ajax({
                        url: "{{ route('fc-api.attributes.store') }}",
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {
                            $('.form-horizontal').trigger("reset");
                            if (result.errors) {
                                $('#div-{{ $control_id }}-modal-error').html('');
                                $('#div-{{ $control_id }}-modal-error').show();
                                $(".alert-danger").show();
                                $("#spinner").hide();
                                $('#btn-save-mdl-{{ $control_id }}-modal').attr('disabled',
                                    false);
                                $.each(result.errors, function(key, value) {

                                    $('.alert-danger').append('<li class="list-unstyled">' +
                                        value +
                                        '</li>');
                                });
                            } else {
                                $(".alert-danger").hide();
                                $('#div-{{ $control_id }}-modal-error').hide();


                                swal({
                                    title: "Saved",
                                    text: "Attribute saved successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false

                                });
                                setTimeout(function() {
                                    location.reload(true);
                                }, 1000);

                            }

                        },
                        error: function(data) {
                            $("#div-{{ $control_id }}-modal-error").show();
                            $("#spinner").hide();
                            $('#btn-save-mdl-{{ $control_id }}-modal').attr('disabled', false);
                            $('#btn-save-mdl-{{ $control_id }}-modal').attr('disabled', false);

                            swal("Error", "Oops an error occurred. Please try again.", "error");

                        }
                    });
                });

                //enable up and down move icon
                $('.form-check-input').change(function() {
                    $('#{{ $control_id }}-downmove-attribute').prop('disabled', !$('.form-check-input:checked').length);
                    $('#{{ $control_id }}-upmove-attribute').prop('disabled', !$('.form-check-input:checked').length);
                });

                //update action for display_ordinal
                
                $('#{{ $control_id }}-upmove-attribute').click(function(e) {
                  
                    $("#spinner1").show();
                    $('#{{ $control_id }}-upmove-attribute').attr('disabled', true)
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    
                    let parent_anchor = $('.model-artifacts-a');
                    
                    let current_position = [];
                    
                    let model_artifacts = $('.model_artifact_attribute');
                    
                    let artifacts = model_artifacts.filter(function(k) {
                        return $(this).prop('checked') == true;
                    })
                    
                    
                    for (let index = 0; index < artifacts.length; index++) {
                        current_position.push(model_artifacts.index(artifacts[index]));
                     
                    }
                    
                    if (artifacts.length > 0 ) {
                       
                        for (let index = 0; index < current_position.length; index++) {
                            if (current_position[index] != 0) {
                                
                                if (current_position[index] == 1) {
                                    let id = $('.model-artifacts-a')[current_position[index] - 1].id;
                                    $(parent_anchor[current_position[index]]).insertBefore($('#' + id));
                                } else {
                                    let id = $('.model-artifacts-a')[current_position[index] - 2].id;
                                    $(parent_anchor[current_position[index]]).insertAfter($('#' + id));
                                }

                            }


                        }



                        $('.model_artifact_attribute').each(function(key, v) {


                            let itemId = $(this).attr('data-val');
                            let endPointUrl =
                                "{{ route('fc-api.attributes.changeDisplayOrdinal', '') }}/" +
                                itemId
                            
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('organization_id', '{{ $organization->id }}');
                            formData.append('display_ordinal', key);
                            formData.append('_method', 'PUT');

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
                                        $('#spinner').hide();

                                        $('#{{ $control_id }}-upmove-attribute').attr(
                                            'disabled', false)
                                        $('#{{ $control_id }}-delete-attribute')
                                            .attr("disabled", false);
                                    } else {
                                        $("#spinner1").hide();
                                        $('#{{ $control_id }}-upmove-attribute').attr(
                                            'disabled', false)
                                    }
                                }
                            })
                        })
                    }
                })
                //down-vote attr
                $('#{{ $control_id }}-downmove-attribute').click(function(e) {
                    $("#spinner2").show();
                    $('#{{ $control_id }}-downmove-attribute').attr('disabled', true);
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    let parent_anchor = $('.model-artifacts-a');

                    let current_position = [];

                    let model_artifacts = $('.model_artifact_attribute');

                    let artifacts = model_artifacts.filter(function() {
                        return $(this).prop('checked') == true;
                    })

                    for (let index = 0; index < artifacts.length; index++) {
                        current_position.push(model_artifacts.index(artifacts[index]));

                    }

                    if (artifacts.length > 0) {

                        for (let index = 0; index < current_position.length; index++) {
                            if (current_position[index] < (model_artifacts.length - 1)) {

                                let id = $('.model-artifacts-a')[current_position[index] + 1].id;
                                $(parent_anchor[current_position[index]]).insertAfter($('#' + id));


                            }


                        }

                         $('.model_artifact_attribute').each(function(key, v) {


                            let itemId = $(this).attr('data-val');
                            let endPointUrl =
                                "{{ route('fc-api.attributes.changeDisplayOrdinal', '') }}/" +
                                itemId
                            
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('organization_id', '{{ $organization->id }}');
                            formData.append('display_ordinal', key);
                            formData.append('_method', 'PUT');

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
                                         $("#spinner2").hide();
                                        $('#{{ $control_id }}-downmove-attribute').attr(
                                            'disabled', false)
                                        $('#{{ $control_id }}-delete-attribute')
                                            .attr("disabled", false);
                                    } else {
                                          $("#spinner2").hide();
                                        $('#{{ $control_id }}-downmove-attribute').attr(
                                            'disabled', false)
                                    }
                                }
                            })
                        })
                    }
                })

                //edit attribute action
                $("#{{ $control_id }}-edit-attribute").click(function(e) {
                   
                         $('.modal-header').trigger("reset");
                        let itemToCopy = [];
                        
                        let model_artifacts = $('.model_artifact_attribute');
                        let artifacts = model_artifacts.filter(function() {
                            return $(this).prop('checked') == true;
                        })
                        for (let index = 0; index < artifacts.length; index++) {
                            itemToCopy.push(model_artifacts.index(artifacts[index]));
                            
                            if (model_artifacts.length > 0) {
                                let id = $('.model-artifacts-a')[itemToCopy[index]].id;
                                $('#{{ $control_id }}-attribute-modal').modal('show');
                              $('.modal-header').find('#lbl-{{ $control_id }}-modal-title').html('<h5>Edit Attribute</h5>'); 
                            let attribute_name = $('#' + id).find('p').find('b').html();
                            let attribute_value = $('#' + id).find('p.attr-val').html();
                            $('#{{ $control_id }}-attribute-name').val(attribute_name)
                            $('#{{ $control_id }}-attribute-value').val(attribute_value)
                            let attribute_id = $('#' + id).find('input').attr('data-val');
                            $("#{{ $control_id }}-selected-attribute-id")
                                .val(attribute_id);
                        }




                    }


                })
                //copy button triggers a modal
                $("#{{ $control_id }}-copy-attribute").click(function(e) {
                    let itemToCopy = [];
                    
                    let model_artifacts = $('.model_artifact_attribute');
                    let artifacts = model_artifacts.filter(function() {
                        return $(this).prop('checked') == true;
                    })
                    for (let index = 0; index < artifacts.length; index++) {
                        itemToCopy.push(model_artifacts.index(artifacts[index]));
                        if (model_artifacts.length > 0) {
                              $("#{{ $control_id }}-copy-attribute").attr('disabled',false)
                            let id = $('.model-artifacts-a')[itemToCopy[index]].id;
                            $('#{{ $control_id }}-attribute-modal').modal('show');
                           $('.modal-header').find('#lbl-{{ $control_id }}-modal-title').html('<h5>Copy Attribute</h5>'); 
                            let attribute_name = $('#' + id).find('p').find('b').html();
                            let attribute_value = $('#' + id).find('p.attr-val').html();
                            $('#{{ $control_id }}-attribute-name').val(attribute_name)
                            $('#{{ $control_id }}-attribute-value').val(attribute_value)
                        }
                        $("#{{ $control_id }}-selected-attribute-id")
                        .val('0');

                        }

                        
                    })
                //refresh action 
                $('#{{ $control_id }}-refresh-attribute').click(function(e) {
                    location.reload();
                })
                //Delete action
                $('#{{ $control_id }}-delete-attribute').click(function(e) {

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });

                    $('#spinner').show();
                    $('#{{ $control_id }}-delete-attribute').attr("disabled",
                        true);
                    let model_artifacts = $('.model_artifact_attribute');
                    // console.log(model_artifacts);
                    let artifacts = model_artifacts.filter(function(k) {
                        return $(this).prop('checked') == true;
                    })
                    if (model_artifacts.length > 0) {


                        swal({
                            title: "Are you sure you want to delete this Attributes?",
                            text: "You will not be able to recover this Attributes record if deleted.",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        }, function(isConfirm) {
                            if (isConfirm) {
                                artifacts.each(function() {

                                    let itemId = $(this).attr(
                                        'data-val');
                                    let endPointUrl =
                                        "{{ route('fc-api.attributes.destroy', '') }}/" +
                                        itemId

                                    let formData = new FormData();
                                    formData.append('_token', $(
                                        'input[name="_token"]'
                                    ).val());
                                    formData.append('_method',
                                        'DELETE');

                                    $.ajax({
                                        url: endPointUrl,
                                        type: "POST",
                                        data: formData,
                                        cache: false,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function(
                                            result) {
                                            if (result
                                                .errors
                                            ) {
                                                $('#spinner')
                                                    .hide();
                                                $('#{{ $control_id }}-delete-attribute')
                                                    .attr(
                                                        "disabled",
                                                        false
                                                    );

                                            } else {
                                                swal({
                                                    title: "Deleted",
                                                    text: "The Attribute record has been deleted.",
                                                    type: "success",
                                                    confirmButtonClass: "btn-success",
                                                    confirmButtonText: "OK",
                                                    closeOnConfirm: false
                                                })
                                                setTimeout(function() {
                                                    location.reload(true);
                                                }, 1000);
                                            }
                                        },
                                    });
                                });
                            }

                        })

                    }


                })


                //Save attribute details
                $('#btn-save-mdl-{{ $control_id }}-attributes-save').click(function(e) {
                    $("#spinner").show();
                    $('#btn-save-mdl-{{ $control_id }}-attributes-save').attr('disabled', true);

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    let formData = new FormData();
                    let endPointUrl = "{{ route('fc-api.attributes.store') }}"
                    let pagePrimaryId = $("#{{ $control_id }}-selected-attribute-id")
                        .val();
                    if (pagePrimaryId != "0") {
                        formData.append('_method', "PUT");
                        endPointUrl = "{{ route('fc-api.attributes.update', '') }}/" + pagePrimaryId
                    }

                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('id', pagePrimaryId);
                    formData.append('artifactable_type', String.raw`{{ get_class($artifactable) }}`)
                    formData.append('artifactable_id', "{{ $artifactable->id }}")
                    formData.append('key', $('#{{ $control_id }}-attribute-name').val());
                    formData.append('value', $('#{{ $control_id }}-attribute-value').val());
                    //formData.append('is_hidden', $('#{{ $control_id }}-page-text-is_hidden').val());
                    //formData.append('is_published', $('#{{ $control_id }}-page-text-is_published').val());
                    formData.append('creator_user_id', "{{ Auth::id() }}");
                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id',
                            '{{ $organization->id }}');
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
                                $("#spinner").hide();
                                $('#btn-save-mdl-{{ $control_id }}-attributes-save').attr(
                                    'disabled',
                                    false);
                                $('#div-{{ $control_id }}-modal-error')
                                    .html('');
                                $('#div-{{ $control_id }}-modal-error')
                                    .show();
                                $('.alert.alert-danger').html('');
                                $('.alert.alert-danger').show();

                                $.each(result.errors, function(key,
                                    value) {
                                    console.log(value);
                                    // $('#div-{{ $control_id }}-page-text-error')
                                    $('.alert.alert-danger')
                                        .append(
                                            `<li class="list-unstyled"> ${value} </li>`);



                                    // $('.alert.alert-danger').show();
                                    // $('#div-{{ $control_id }}-modal-error').show()
                                });


                            } else {
                                $('#div-{{ $control_id }}-page-text-error')
                                    .hide();

                                swal({
                                    title: "Saved",
                                    text: "Page saved successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: true
                                })
                                setTimeout(function() {
                                    location.reload(true);
                                }, 1000);
                            }

                        },
                        error: function(data) {
                            console.log(data);

                            swal(
                                "Oops an error occurred. Please try again."
                            );
                            $('#{{ $control_id }}-delete-attribute').attr("disabled", false);





                        }
                    });
                });

            });
        </script>
    @endpush

@endif

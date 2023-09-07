<div class="row">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <h6 class="card-title">
                    <i class="fa fa-list-alt fa-fw"></i> Available Checklists
                </h6>

                <div id="aitem" class="list-group">
                    @if (isset($checklists) && count($checklists) > 0)
                        @foreach ($checklists as $item)
                            <a href="{{ route(\Route::current()->getName(), 'name=' . $item) }}"
                                class="list-group-item {{ $selected_checklist_name == $item ? 'active' : '' }}">
                                <p class="list-group-item-heading">{{ $item }}</p>
                            </a>
                        @endforeach
                    @else
                        <p class="list-group-item-heading text-center mt-5 mb-5">No Checklists</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">

            <div class="card-body">

                <div class="card-title">
                    <div class="row">
                        <div class="col-md-8">
                            <i class="fa fa-list fa-fw"></i> Checklist Items
                        </div>
                        <div class="col-md-4">
                            <div class="text-end">
                                @if (Request::query('name'))
                                    <button id="btn-add-item" type="button"
                                        class="btn btn-danger btn-sm my-1 py-1 mx-1 px-1">
                                        Add New Item
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="cbx_list_name" value="{{ isset($selected_checklist_name) ? $selected_checklist_name : null }}" />

                @if (isset($selected_checklist_items) and count($selected_checklist_items) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style='width:20px;'>ID</th>
                                    <th>Description</th>
                                    <th style='width:100px;'></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selected_checklist_items as $item)
                                    <tr>
                                        <td id="cbx_item_{{ $item->id }}_idx">{{ $item->ordinal }}</td>
                                        <td>
                                            <span
                                                id="cbx_item_{{ $item->id }}_desc">{{ $item->item_description }}</span>
                                            <input id="cbx_item_{{ $item->id }}_requires_attachment" type="hidden"
                                                value="{{ $item->requires_attachment == true ? 1 : 0 }}" />
                                            <input id="cbx_item_{{ $item->id }}_required_attachment_mime_type"
                                                type="hidden" value="{{ $item->required_attachment_mime_type }}" />

                                            <input id="cbx_item_{{ $item->id }}_requires_input" type="hidden"
                                                value="{{ $item->requires_input == true ? 1 : 0 }}" />
                                            <input id="cbx_item_{{ $item->id }}_required_input_type" type="hidden"
                                                value="{{ $item->required_input_type }}" />
                                            <input id="cbx_item_{{ $item->id }}_required_input_validation"
                                                type="hidden" value="{{ $item->required_input_validation }}" />

                                            @if ($item->requires_attachment)
                                                <br />
                                                <span class="small text-danger"><em>This checklist item requires an
                                                        attachment.
                                                        {{ $item->required_attachment_mime_type }}</em></span>
                                            @endif
                                            @if ($item->requires_input)
                                                <br />
                                                <span class="small text-danger"><em>This checklist item requires a text
                                                        input. {{ $item->required_input_type }}
                                                        {{ $item->required_input_validation }}</em></span>
                                            @endif
                                            @if (isset($attribute_groups) && count($attribute_groups)>0 )
                                                <br/>
                                                @foreach($attribute_groups as $attribute_idx => $attribute_group)
                                                    @php
                                                        $artifact_key = null;
                                                        if (isset($attribute_idx)){
                                                            $artifact_key = $attribute_idx; 
                                                        }

                                                        $artifact_label = null;
                                                        if (isset($attribute_group['name'])){
                                                            $artifact_label = $attribute_group['name']; 
                                                        }

                                                        $artifact_value_type = null;
                                                        if (isset($attribute_group['value-type'])){
                                                            $artifact_value_type = $attribute_group['value-type'];
                                                        }

                                                        $artifact_value_default = null;
                                                        if (isset($attribute_group['value-default'])){
                                                            $artifact_value_default = $attribute_group['value-default'];
                                                        }
                                                    @endphp
                                                    <span style="font-size:85%">
                                                        <x-hasob-foundation-core::single-artifact-editor 
                                                            :artifactable="$item" 
                                                            :artifact_key="$artifact_key"
                                                            :button_label="$artifact_label"
                                                            :artifact_label="$artifact_label"
                                                            :artifact_value_type="$artifact_value_type"
                                                            :artifact_value_default="$artifact_value_default"
                                                        />
                                                    </span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#"><i class="fa fa-edit fa-fw btn-edit-item"
                                                    data-val="{{ $item->id }}"></i></a>
                                            <a href="#"><i class="fa fa-trash fa-fw btn-delete-item"
                                                    data-val="{{ $item->id }}"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <br /><br />
                    <h5 class="text-center">No Checklist Selected</h5>
                    <br /><br />
                @endif

            </div>
        </div>
    </div>

</div>

<div id="spinner1" class="">
    <div class="loader" id="loader-1"></div>
</div>

@include(
    'hasob-foundation-core::checklists.partials.check-list-creator-modal'
)
@include(
    'hasob-foundation-core::checklists.partials.check-list-item-editor-modal'
)


@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.spinner').hide();
            $('.offline').hide();

            $('#btn-new-template').click(function() {
                $('#frm_checklist_creator').trigger("reset");
                $('#error_checklist_creator').hide();
                $('#check-list-creator-modal').modal('show');
            });

            $("#btn-checklist-creator-save").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                e.preventDefault();

                $('.spinner').show();
                $('#btn-checklist-creator-save').prop("disabled", true);

                let formData = new FormData();
                options = JSON.stringify({
                    'new_checklist_name': $('#new_checklist_name').val(),
                });
                formData.append('options', options);

                $.ajax({
                    url: "{{ route('fc.checklist-template.store') }}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {

                        if (data != null && data.status == 'fail') {
                            $('#error_checklist_creator').html('');
                            $('#error_msg_checklist_creator').html('');
                            $('#error_checklist_creator').show();

                            console.log(data);
                            if (data.response != null) {
                                for (x in data.response) {
                                    if ($.isArray(data.response[x])) {
                                        $('#error_checklist_creator').append(
                                            '<strong>Errors</strong><br/>' + data.response[
                                                x].join('<br/>'));
                                    } else {
                                        $('#error_checklist_creator').append(
                                            '<strong>Errors</strong><br/>' + data.response[
                                                x]);
                                    }
                                }
                            } else {
                                $('#error_checklist_creator').append(
                                    '<strong>Error</strong><br/>An error has occurred.');
                            }

                            $('.spinner').hide();
                            $('#btn-checklist-creator-save').prop("disabled", false);

                        } else if (data != null && data.status == 'ok') {
                            swal({
                                title: "Saved",
                                text: "Checklist saved",
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
                            $('#error_msg_checklist_creator').html(
                                '<strong>Error</strong><br/>An error has occurred.');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        $('.spinner').hide();
                        $('#btn-checklist-creator-save').prop("disabled", false);
                    }
                });
            });

            @php 
                if (isset($selected_idx_max)==false){
                    $selected_idx_max = 0;
                }
            @endphp

            $('#btn-add-item').click(function() {
                $('#frm_checklist_editor').trigger("reset");
                $('#error_checklist_editor').hide();

                $('#checklist_id').val(0);
                $('#checklist_idx').val({{ $selected_idx_max + 1 }});
                $('#checklist_description').val("");

                $('#check-list-item-editor-modal').modal('show');
            });

            $("#btn-checklist-editor-save").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                e.preventDefault();

                $('.spinner').show();
                $('#btn-checklist-editor-save').prop("disabled", true);
               

                var formData = new FormData();
                options = JSON.stringify({
                    'cbx_idx': $('#ordinal').val(),
                    'cbx_item_id': $('#checklist_id').val(),
                    'cbx_desc': $('#item_description').val(),
                    'cbx_list_name': '{{ isset($selected_checklist_name) ? $selected_checklist_name:"" }}',
                    'cbx_requires_attachment': $('#requires_attachment').is(':checked'),
                    'cbx_required_attachment_mime_type': $('#required_attachment_mime_type').val(),
                    'cbx_requires_input': $('#requires_input').is(':checked'),
                    'cbx_required_input_type': $('#required_input_type').val(),
                    'cbx_required_input_validation': $('#required_input_validation').val(),
                });
                formData.append('options', options);

                $.ajax({
                    url: "{{ route('fc.checklist-template-item.store') }}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {

                        if (data != null && data.status == 'fail') {
                            $('#error_checklist_editor').show();
                            if (data.response != null) {
                                for (x in data.response) {
                                    if ($.isArray(data.response[x])) {
                                        $('#error_checklist_editor').html(
                                            '<strong>Errors</strong><br/>' + data.response[
                                                x].join('<br/>'));
                                    } else {
                                        $('#error_checklist_editor').html(
                                            '<strong>Errors</strong><br/>' + data.response[
                                                x]);
                                    }
                                }
                            } else {
                                $('#error_checklist_editor').html(
                                    '<strong>Error</strong><br/>An error has occurred.');
                            }

                            $('.spinner').hide();
                            $('#btn-checklist-editor-save').prop("disabled", false);

                        } else if (data != null && data.status == 'ok') {
                            swal({
                                title: "Saved",
                                text: "Checklist template item saved",
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
                            $('#error_checklist_editor').html(
                                '<strong>Error</strong><br/>An error has occurred.');
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        $('.spinner').hide();
                        $('#btn-checklist-editor-save').prop("disabled", false);
                    }
                });
            });

            $('.btn-delete-item').click(function(e) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                e.preventDefault();

                $('#spinner1').show();
                $('#btn-delete-item').prop("disabled", true);

                //check for internet status 
                if (!window.navigator.onLine) {
                    $('.offline').fadeIn(300);
                    return;
                } else {
                    $('.offline').fadeOut(300);
                }

                let cbx_item_id = $(this).attr('data-val');
                swal({
                    title: "Are you sure you want to delete this item?",
                    text: "You will not be able to recover this item if deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {

                        var formData = new FormData();
                        options = JSON.stringify({
                            'cbx_item_id': cbx_item_id,
                        });
                        formData.append('options', options);

                        $.ajax({
                            type: "POST",
                            url: "{{ route('fc.checklist.delete', '') }}/" + cbx_item_id,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                if (result.errors) {
                                    console.log(result.errors)
                                    swal("Error",
                                        "Oops an error occurred. Please try again.",
                                        "error");
                                } else {
                                    //swal("Deleted", "Rating deleted successfully.", "success");
                                    swal({
                                        title: "Deleted",
                                        text: "Item deleted successfully",
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
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });

                // if (swal('Are you sure you want to delete this item?')){

                //     $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                //     e.preventDefault();

                //     $('#spinner1').show();
                //     $('#btn-delete-item').prop("disabled", true);

                //     var formData = new FormData();
                //     options = JSON.stringify({
                //         'cbx_item_id':$(this).attr('data-val'),
                //     });
                //     formData.append('options', options);

                //     $.ajax({
                //         type: "POST",
                //         url: "{{ route('fc.checklist.delete', '') }}/"+$('#checklist_id').val(),
                //         data: formData,
                //         processData: false,
                //         contentType: false,
                //         success: function (data) { },
                //         error: function(data){ console.log('Error:', data); }
                //     });

                //     location.reload();
                // }

            });

            $('.btn-edit-item').click(function() {
                $('#frm_checklist_editor').trigger("reset");
                $('#error_checklist_editor').hide();

                var item_id = $(this).attr('data-val');
                $('#checklist_id').val(item_id);
                $('#ordinal').val($("#cbx_item_" + item_id + "_idx")[0].innerHTML);
                $('#item_description').val($("#cbx_item_" + item_id + "_desc")[0].innerHTML);

                $('#required_attachment_mime_type').val($("#cbx_item_" + item_id +
                    "_required_attachment_mime_type").val());
                if ($("#cbx_item_" + item_id + "_requires_attachment").val() == "1") {
                    $('#requires_attachment')[0].checked = true;
                }

                $('#required_input_validation').val($("#cbx_item_" + item_id + "_required_input_validation")
                    .val());
                $('#required_input_type').val($("#cbx_item_" + item_id + "_required_input_type").val());
                if ($("#cbx_item_" + item_id + "_requires_input").val() == "1") {
                    $('#requires_input')[0].checked = true;
                }

                $('#check-list-item-editor-modal').modal('show');
            });

        });
    </script>
@endpush

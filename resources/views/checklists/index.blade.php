@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
{{ $selected_checklist_name ?: 'Checklists' }}
@stop

@section('page_title')
{{ $selected_checklist_name ?: 'Checklists' }}
@stop

@push('page_css')
@endpush

@section('content')

    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-check-square-o fa-fw"></i> Available Checklists
                    <button id="btn-new-template" type="button" class="btn btn-warning btn-xs pull-right">
                        Add New Checklist
                    </button>
                </div>
                <div class="panel-body">
                    <div id="aitem" class="list-group">
                        @if (isset($checklists))
                            @foreach ($checklists as $item)
                                <a href="{{ route('fc.checklists.index','name='.$item) }}" class="list-group-item {{ $selected_checklist_name==$item?'active':'' }}">
                                    <p class="list-group-item-heading">{{ $item }}</p>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i> Checklist Items
                    <button id="btn-add-item" type="button" class="btn btn-primary btn-xs pull-right">
                        Add New Item
                    </button>
                </div>
                <div class="panel-body">

                    <input type="hidden" id="cbx_list_name" value="{{ $selected_checklist_name }}" />

                    @if (isset($selected_checklist_items) and count($selected_checklist_items)>0)
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
                                        <td id="cbx_item_{{$item->id}}_idx">{{ $item->ordinal }}</td>
                                        <td>
                                            <span id="cbx_item_{{$item->id}}_desc">{{ $item->item_description }}</span>
                                            <input id="cbx_item_{{$item->id}}_requires_attachment" type="hidden" value="{{ $item->requires_attachment==true?1:0 }}" />
                                            <input id="cbx_item_{{$item->id}}_required_attachment_mime_type" type="hidden" value="{{ $item->required_attachment_mime_type }}" />

                                            <input id="cbx_item_{{$item->id}}_requires_input" type="hidden" value="{{ $item->requires_input==true?1:0 }}" />
                                            <input id="cbx_item_{{$item->id}}_required_input_type" type="hidden" value="{{ $item->required_input_type }}" />
                                            <input id="cbx_item_{{$item->id}}_required_input_validation" type="hidden" value="{{ $item->required_input_validation }}" />

                                            @if ($item->requires_attachment)
                                                <br/>
                                                <span class="small text-danger"><em>This checklist item requires an attachment. {{$item->required_attachment_mime_type}}</em></span>
                                            @endif
                                            @if ($item->requires_input)
                                                <br/>
                                                <span class="small text-danger"><em>This checklist item requires a text input. {{ $item->required_input_type }} {{ $item->required_input_validation }}</em></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#"><i class="fa fa-edit fa-fw btn-edit-item" data-val="{{ $item->id }}"></i></a>
                                            <a href="#"><i class="fa fa-trash fa-fw btn-delete-item" data-val="{{ $item->id }}"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <br/><br/>
                        <h5 class="text-center">No Checklist Selected</h5>
                        <br/><br/>
                    @endif

                </div>
            </div>
        </div>

    </div>

    <div id="spinner1" class="">
        <div class="loader" id="loader-1"></div>
    </div>

    @include('hasob-foundation-core::checklists.partials.check-list-creator-modal')
    @include('hasob-foundation-core::checklists.partials.check-list-item-editor-modal')

@endsection

@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function(){

        $('#spinner1').hide();

        $('#btn-new-template').click(function(){
            $('#frm_checklist_creator').trigger("reset");
            $('#error_checklist_creator').hide();
            $('#check-list-creator-modal').modal('show');
        });
        
        $("#btn-checklist-creator-save").click(function(e){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            e.preventDefault();

            $('#spinner1').show();
            $('#btn-checklist-creator-save').prop("disabled", true);

            var formData = new FormData();
            options = JSON.stringify({
                'new_checklist_name':$('#new_checklist_name').val(),
            });
            formData.append('options', options);

            $.ajax({
                url: "{{ route('fc.checklist-template.store') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){

                    if (data!=null && data.status=='fail'){
                        $('#error_checklist_creator').show();
                        if (data.response!=null){
                            for (x in data.response) {
                                if ($.isArray(data.response[x])){
                                    $('#error_msg_checklist_creator').html('<strong>Errors</strong><br/>'+data.response[x].join('<br/>'));
                                }else{
                                    $('#error_msg_checklist_creator').html('<strong>Errors</strong><br/>'+data.response[x]);
                                }
                            }
                        } else {
                            $('#error_msg_checklist_creator').html('<strong>Error</strong><br/>An error has occurred.');
                        }

                        $('#spinner1').hide();
                        $('#btn-checklist-creator-save').prop("disabled", false);

                    }else if (data!=null && data.status=='ok'){
                        alert("Checklist saved.")
                        location.reload();
                    }else{
                        $('#error_msg_checklist_creator').html('<strong>Error</strong><br/>An error has occurred.');
                    }
                },
                error: function(data){
                    console.log(data);
                    $('#spinner1').hide();
                    $('#btn-checklist-creator-save').prop("disabled", false);
                }
            });
        });

        $('#btn-add-item').click(function(){
            $('#frm_checklist_editor').trigger("reset");
            $('#error_checklist_editor').hide();
            
            $('#checklist_id').val(0);
            $('#checklist_idx').val({{ $selected_idx_max+1 }});
            $('#checklist_description').val("");

            $('#check-list-item-editor-modal').modal('show');
        });

        $("#btn-checklist-editor-save").click(function(e){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            e.preventDefault();

            $('#spinner1').show();
            $('#btn-checklist-editor-save').prop("disabled", true);

            var formData = new FormData();
            options = JSON.stringify({
                'cbx_idx':$('#ordinal').val(),
                'cbx_item_id':$('#checklist_id').val(),
                'cbx_desc':$('#item_description').val(),
                'cbx_list_name':'{{ $selected_checklist_name }}',
                'cbx_requires_attachment':$('#requires_attachment').is(':checked'),
                'cbx_required_attachment_mime_type':$('#required_attachment_mime_type').val(),
                'cbx_requires_input':$('#requires_input').is(':checked'),
                'cbx_required_input_type':$('#required_input_type').val(),
                'cbx_required_input_validation':$('#required_input_validation').val(),
            });
            formData.append('options', options);

            $.ajax({
                url: "{{ route('fc.checklist-template-item.store') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){

                    if (data!=null && data.status=='fail'){
                        $('#error_checklist_editor').show();
                        if (data.response!=null){
                            for (x in data.response) {
                                if ($.isArray(data.response[x])){
                                    $('#error_msg_checklist_editor').html('<strong>Errors</strong><br/>'+data.response[x].join('<br/>'));
                                }else{
                                    $('#error_msg_checklist_editor').html('<strong>Errors</strong><br/>'+data.response[x]);
                                }
                            }
                        } else {
                            $('#error_msg_checklist_editor').html('<strong>Error</strong><br/>An error has occurred.');
                        }

                        $('#spinner1').hide();
                        $('#btn-checklist-editor-save').prop("disabled", false);

                    }else if (data!=null && data.status=='ok'){
                        alert("Checklist template item saved")
                        location.reload();
                    }else{
                        $('#error_msg_checklist_editor').html('<strong>Error</strong><br/>An error has occurred.');
                    }
                },
                error: function(data){
                    console.log(data);
                    $('#spinner1').hide();
                    $('#btn-checklist-editor-save').prop("disabled", false);
                }
            });
        });

        $('.btn-delete-item').click(function(e){
            if (confirm('Are you sure you want to delete this item?')){

                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                $('#spinner1').show();
                $('#btn-delete-item').prop("disabled", true);

                var formData = new FormData();
                options = JSON.stringify({
                    'cbx_item_id':$(this).attr('data-val'),
                });
                formData.append('options', options);

                $.ajax({
                    type: "POST",
                    url: "{{ route('fc.checklist.delete','') }}/"+$('#checklist_id').val(),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) { },
                    error: function(data){ console.log('Error:', data); }
                });

                location.reload();
            }
        });

        $('.btn-edit-item').click(function(){
            $('#frm_checklist_editor').trigger("reset");
            $('#error_checklist_editor').hide();

            var item_id = $(this).attr('data-val');
            $('#checklist_id').val(item_id);
            $('#ordinal').val($("#cbx_item_"+item_id+"_idx")[0].innerHTML);
            $('#item_description').val($("#cbx_item_"+item_id+"_desc")[0].innerHTML);

            $('#required_attachment_mime_type').val($("#cbx_item_"+item_id+"_required_attachment_mime_type").val());
            if ($("#cbx_item_"+item_id+"_requires_attachment").val()=="1"){
                $('#requires_attachment')[0].checked = true;
            }

            $('#required_input_validation').val($("#cbx_item_"+item_id+"_required_input_validation").val());
            $('#required_input_type').val($("#cbx_item_"+item_id+"_required_input_type").val());
            if ($("#cbx_item_"+item_id+"_requires_input").val()=="1"){
                $('#requires_input')[0].checked = true;
            }
            
            $('#check-list-item-editor-modal').modal('show');
        });

    });
</script>
@endpush
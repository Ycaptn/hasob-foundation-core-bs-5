
@if ($templated_model!=null)

    <div class="btn-group col-lg-2">
        <a id="btn-new-mdl-documentGenerationTemplate-modal" class="btn btn-sm btn-primary btn-new-mdl-documentGenerationTemplate-modal">
            <i class="bx bx-book-add me-1"></i>New Template
        </a>
    </div>

    @foreach($templated_model->get_model_templates() as $idx=>$template)
        @if ($template!=null && $template->documentGenerationTemplate!=null)
        <div class="col-12 col-md-12 col-sm-12">
            <div class="card">
                @php
                    $detail_page_url = route('fc.documentGenerationTemplates.show', $template->document_generation_template_id);
                @endphp
                <div class="row g-0">
                    <div class="col-xs-12 col-md-1 align-middle text-center p-2">
                        <a href='#' data-val='{{$template->document_generation_template_id}}' class="btn-edit-mdl-documentGenerationTemplate-modal">
                            <div class="ms-2 fm-icon-box radius-10 bg-primary text-white text-center">
                                <i class="bx bx-message-square-edit"></i>
                            </div>
                        </a>
                        <div class="d-flex align-items-center">
                            <div class="ms-auto"> 
                                <a data-toggle="tooltip" 
                                    title="Edit" 
                                    data-val='{{$template->document_generation_template_id}}' 
                                    class="btn-edit-mdl-documentGenerationTemplate-modal me-1" href="#">
                                    <i class="bx bxs-edit"></i>
                                </a>
                                <a data-toggle="tooltip" 
                                    title="Delete" 
                                    data-val-model-doc-id='{{$template->id}}' 
                                    data-val='{{$template->document_generation_template_id}}' 
                                    class="btn-delete-mdl-documentGenerationTemplate-modal me-1" href="#">
                                    <i class="bx bxs-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-11">
                        <div class="card-body">
                            <a href='#' data-val='{{$template->document_generation_template_id}}' class="btn-edit-mdl-documentGenerationTemplate-modal">
                                <h3 class="h6 card-title mb-0">
                                    {{ $template->documentGenerationTemplate->title }}
                                </h3>
                            </a>
                            @if (!empty($template->documentGenerationTemplate->output_content_types))
                                <p class="card-text mb-0 small">
                                    {{ $template->documentGenerationTemplate->output_content_types }}
                                </p>
                            @endif

                            <p class="card-text text-muted small">
                                Created: {{ \Carbon\Carbon::parse($template->documentGenerationTemplate->created_at)->format('l jS F Y') }} - {!! \Carbon\Carbon::parse($template->documentGenerationTemplate->created_at)->diffForHumans() !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <div class="modal fade" id="mdl-documentGenerationTemplate-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
    
                <form class="form-horizontal" id="frm-documentGenerationTemplate-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="modal-header">                        
                        <div class="col-lg-11">
                            {!! Form::text("{$control_id}_title", null, ['placeholder'=>'Title','id'=>"{$control_id}_title",'class'=>'form-control','minlength' => 4,'maxlength' => 150]) !!}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <div id="div-documentGenerationTemplate-modal-error" class="alert alert-danger" role="alert"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                
                                @csrf
                                
                                <div class="offline-flag"><span class="offline-document_generation_templates">You are currently offline</span></div>
    
                                <div id="spinner-document_generation_templates" class="spinner-border text-primary" role="status"> 
                                    <span class="visually-hidden">Loading...</span>
                                </div>
    
                                <input type="hidden" id="txt-documentGenerationTemplate-primary-id" value="0" />
    
                                <div id="div-content" class="form-group">
                                    <div class="col-lg-12">
                                        <textarea id="{{$control_id}}_content" name="{{$control_id}}_content"></textarea>
                                    </div>
                                </div>
    
                            </div>
                            {{--                             
                            <div class="col-lg-2">
    
                                <label class="col-lg-12 small col-form-label fw-bold">Ouput Formats</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="text/plain" name="cbx-output-format" id="cbx-plain">
                                    <label class="form-check-label" for="cbx-plain">Plain Text</label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="application/msword" name="cbx-output-format" id="cbx-ms-word">
                                    <label class="form-check-label" for="cbx-ms-word">MS Word</label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="application/pdf" name="cbx-output-format" id="cbx-pdf">
                                    <label class="form-check-label" for="cbx-pdf">PDF</label>
                                </div>
    
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="text/html" name="cbx-output-format" id="cbx-html">
                                    <label class="form-check-label" for="cbx-html">HTML</label>
                                </div>
    
                                <div id="div-document_layout" class="form-group">
                                    <label class="col-lg-12 small col-form-label fw-bold">Document Layout</label>
                                    <div class="col-lg-11">
                                        <select id="sel_document_layout" name="sel_document_layout" class="form-select">
                                            <option value="portriat">Portriat</option>
                                            <option value="landscape">Landscape</option>
                                        </select>
                                    </div>
                                </div>                            
    
                            </div> 
                            --}}

                        </div>
                    </div>
                </form>
            
                <div class="modal-footer" id="div-save-mdl-documentGenerationTemplate-modal">
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-documentGenerationTemplate-modal" value="add">Save</button>
                </div>
    
            </div>
        </div>
    </div>

@else
    <p class="text-center text-danger p-5">No templates</p>
@endif


@push('page_css')
<link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.css') }}" />
<link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/simplemde-1.11.2-dist/simplemde.min.css') }}" />
<style type="text/css">
    .CodeMirror {
        height: 500px;
    }
    .editor-preview-active,
    .editor-preview-active-side {
        /*display:block;*/
    }
    .editor-preview-side>p,
    .editor-preview>p {
        margin:inherit;
    }
    .editor-preview pre,
    .editor-preview-side pre {
        background:inherit;
        margin:inherit;
    }
    .editor-preview table td,
    .editor-preview table th,
    .editor-preview-side table td,
    .editor-preview-side table th {
        border:inherit;
        padding:inherit;
    }
    .view_data_param {
        cursor: pointer;
    }
</style>
@endpush

@push('page_scripts')
<script src="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.js') }}"></script>
<script src="{{ asset('hasob-foundation-core/assets/simplemde-1.11.2-dist/simplemde.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

    //Initiate the Markdown Editor
    var simplemde = new SimpleMDE({ 
        element: $("#{{$control_id}}_content")[0],
        toolbar: [
            {
                    name: "bold",
                    action: SimpleMDE.toggleBold,
                    className: "fa fa-bold",
                    title: "Bold",
            },
            {
                    name: "italic",
                    action: SimpleMDE.toggleItalic,
                    className: "fa fa-italic",
                    title: "Italic",
            },
            {
                    name: "strikethrough",
                    action: SimpleMDE.toggleStrikethrough,
                    className: "fa fa-strikethrough",
                    title: "Strikethrough",
            },
            {
                    name: "heading",
                    action: SimpleMDE.toggleHeadingSmaller,
                    className: "fa fa-header",
                    title: "Heading",
            },
            {
                    name: "code",
                    action: SimpleMDE.toggleCodeBlock,
                    className: "fa fa-code",
                    title: "Code",
            },
            "|",
            {
                    name: "unordered-list",
                    action: SimpleMDE.toggleBlockquote,
                    className: "fa fa-list-ul",
                    title: "Generic List",
            },
            {
                    name: "uordered-list",
                    action: SimpleMDE.toggleOrderedList,
                    className: "fa fa-list-ol",
                    title: "Numbered List",
            },
            {
                    name: "clean-block",
                    action: SimpleMDE.cleanBlock,
                    className: "fa fa-eraser fa-clean-block",
                    title: "Clean block",
            },
            "|",
            {
                    name: "link",
                    action: SimpleMDE.drawLink,
                    className: "fa fa-link",
                    title: "Create Link",
            },
            {
                    name: "image",
                    action: SimpleMDE.drawImage,
                    className: "fa fa-picture-o",
                    title: "Insert Image",
            },
            {
                    name: "horizontal-rule",
                    action: SimpleMDE.drawHorizontalRule,
                    className: "fa fa-minus",
                    title: "Insert Horizontal Line",
            },
            "|",
            {
                name: "button-component",
                action: setButtonComponent,
                className: "fa fa-hand-pointer-o",
                title: "Button Component",
            },
            {
                name: "table-component",
                action: setTableComponent,
                className: "fa fa-table",
                title: "Table Component",
            },
            {
                name: "promotion-component",
                action: setPromotionComponent,
                className: "fa fa-bullhorn",
                title: "Promotion Component",
            },
            {
                name: "panel-component",
                action: setPanelComponent,
                className: "fa fa-thumb-tack",
                title: "Panel Component",
            },
            "|",
            {
                    name: "side-by-side",
                    action: SimpleMDE.toggleSideBySide,
                    className: "fa fa-columns no-disable no-mobile",
                    title: "Toggle Side by Side",
            },
            {
                    name: "fullscreen",
                    action: SimpleMDE.toggleFullScreen,
                    className: "fa fa-arrows-alt no-disable no-mobile",
                    title: "Toggle Fullscreen",
            },
            {
                    name: "preview",
                    action: SimpleMDE.togglePreview,
                    className: "fa fa-eye no-disable",
                    title: "Toggle Preview",
            },
        ],
        renderingConfig: { singleLineBreaks: true, codeSyntaxHighlighting: true,},
        hideIcons: ["guide"],
        spellChecker: false,
        promptURLs: true,
        placeholder: "Write contents here .... ",
    });
    function setButtonComponent(editor) {
        link = prompt('Button Link');
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Button Text';
        output = `
[component]: # ('mail::button',  ['url' => '`+ link +`'])
` + text + `
[endcomponent]: # 
                `;
        cm.replaceSelection(output);
    }
    function setPromotionComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Promotion Text';
        output = `
[component]: # ('mail::promotion')
` + text + `
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }
    function setPanelComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Panel Text';
        output = `
[component]: # ('mail::panel')
` + text + `
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }
    function setTableComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        output = `
[component]: # ('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }
    $('.preview-toggle').click(function(){
        simplemde.togglePreview();
        $(this).toggleClass('active');
    });

    $('.offline-document_generation_templates').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-documentGenerationTemplate-modal", function(e) {
        $('#div-documentGenerationTemplate-modal-error').hide();
        $('#mdl-documentGenerationTemplate-modal').modal('show');
        $('#frm-documentGenerationTemplate-modal').trigger("reset");
        $('#txt-documentGenerationTemplate-primary-id').val(0);

        $('#div-show-txt-documentGenerationTemplate-primary-id').hide();
        $('#div-edit-txt-documentGenerationTemplate-primary-id').show();

        $("#spinner-document_generation_templates").hide();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);

        simplemde.value("Template text goes here");
        simplemde.codemirror.refresh();

        $('#title').val("");
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-documentGenerationTemplate-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-documentGenerationTemplate-modal-error').hide();
        $('#mdl-documentGenerationTemplate-modal').modal('show');
        $('#frm-documentGenerationTemplate-modal').trigger("reset");

        $("#spinner-document_generation_templates").show();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', true);

        $('#div-show-txt-documentGenerationTemplate-primary-id').hide();
        $('#div-edit-txt-documentGenerationTemplate-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.document_generation_templates.show','') }}/"+itemId).done(function( response ) {     

            simplemde.value(response.data.content);
            simplemde.codemirror.refresh();
            
			$('#txt-documentGenerationTemplate-primary-id').val(response.data.id);
            $('#{{$control_id}}_title').val(response.data.title);
            $("#spinner-document_generation_templates").hide();
            $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);

        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-documentGenerationTemplate-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-document_generation_templates').fadeIn(300);
            return;
        }else{
            $('.offline-document_generation_templates').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        let docId = $(this).attr('data-val-model-doc-id');
        swal({
                title: "Are you sure you want to delete this Template?",
                text: "You will not be able to recover this Template if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.document_generation_templates.destroy','') }}/"+itemId;

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('_method', 'DELETE');
                    
                    $.ajax({
                        url:endPointUrl,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result){
                            if(result.errors){
                                console.log(result.errors)
                                swal("Error", "Oops an error occurred. Please try again.", "error");
                            }else{

                                let endPointUrl = "{{ route('fc-api.model_documents.destroy','') }}/"+docId;
                                let formData = new FormData();
                                formData.append('_token', $('input[name="_token"]').val());
                                formData.append('_method', 'DELETE');
                                $.ajax({
                                    url:endPointUrl,
                                    type: "POST",
                                    data: formData,
                                    cache: false,
                                    processData:false,
                                    contentType: false,
                                    dataType: 'json',
                                });

                                swal({
                                        title: "Deleted",
                                        text: "Template deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },function(){
                                        location.reload(true);
                                });
                            }
                        },
                    });
                }
            });

    });

    //Save details
    $('#btn-save-mdl-documentGenerationTemplate-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-document_generation_templates').fadeIn(300);
            return;
        }else{
            $('.offline-document_generation_templates').fadeOut(300);
        }

        $("#spinner-document_generation_templates").show();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.document_generation_templates.store') }}";
        let primaryId = $('#txt-documentGenerationTemplate-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.document_generation_templates.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        formData.append('content', simplemde.value());
        formData.append('no_cascade', 0);
        formData.append('title',$("#{{$control_id}}_title").val());
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){
					$('#div-documentGenerationTemplate-modal-error').html('');
					$('#div-documentGenerationTemplate-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-documentGenerationTemplate-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-documentGenerationTemplate-modal-error').hide();

                    if ($('#txt-documentGenerationTemplate-primary-id').val() == "0"){
                        let formData = new FormData();
                        formData.append('_token', $('input[name="_token"]').val());
                        formData.append('_method', actionType);
                        formData.append('model_primary_id', '{{$templated_model->id}}');
                        formData.append('model_type_name', String.raw`{{get_class($templated_model)}}`);
                        formData.append('document_generation_template_id', result.data.id);
                        formData.append('is_default_template', 1);
                        @if (isset($organization) && $organization!=null)
                            formData.append('organization_id', '{{$organization->id}}');
                        @endif

                        $.ajax({
                            url: "{{ route('fc-api.model_documents.store') }}",
                            type: "POST",
                            data: formData,
                            cache: false,
                            processData:false,
                            contentType: false,
                            dataType: 'json',
                            success: function(result){
                                if(result.errors){
                                    $('#div-documentGenerationTemplate-modal-error').html('');
                                    $('#div-documentGenerationTemplate-modal-error').show();
                                    
                                    $.each(result.errors, function(key, value){
                                        $('#div-documentGenerationTemplate-modal-error').append('<li class="">'+value+'</li>');
                                    });
                                }
                            }, error: function(data){ console.log(data); }
                        });
                    }
                    
                    window.setTimeout( function(){
                        $('#div-documentGenerationTemplate-modal-error').hide();
                        swal({
                                title: "Saved",
                                text: "Template saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });
                    },20);
                }

                $("#spinner-document_generation_templates").hide();
                $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-document_generation_templates").hide();
                $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush
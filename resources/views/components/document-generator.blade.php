

@if ($document_generator!=null)

    @push('page_css')
    <style type="text/css">
        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width:1200px;
            }
        }
        #document-generator-modal > .modal {
            height: 100vh;
        }
        #document-generator-modal > .modal-dialog {
            height: 100vh;
        }
        #document-generator-modal > .modal-content {
            height: 95vh;
        }
    </style>
    @endpush

    <div class="modal fade" id="{{ $control_id }}-modal" role="dialog" aria-labelledby="{{ $control_id }}-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $control_id }}-modal-label"> Document Generator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="{{ $control_id }}_error_div" class="alert alert-danger text-left" role="alert">
                        <span id="{{ $control_id }}_error_msg"></span>
                    </div>
                    
                    <div id="{{ $control_id }}_spinner" class="">
                        <div class="loader" id="{{ $control_id }}_loader"></div>
                    </div>

                    <form id="{{ $control_id }}_frm" name="{{ $control_id }}_frm" class="" novalidate="">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 id="{{$control_id}}_initial_notice" class="text-danger text-center my-4"> Select a template to generate the document </h5>
                                        <embed id="{{$control_id}}_pdfEmbed" src="" width="100%" height="100%" style='height:75vh'/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 py-2">
                                <div class="col-lg-12">
                                    @php
                                        $templates = $document_generator->get_templates();
                                    @endphp
                                    @if (count($templates) > 0)

                                        @if (count($model_documents)>0)
                                            <label class="col-lg-12 small col-form-label fw-bold">Overlay Template</label>
                                            <select id="{{ $control_id }}_sel_model_template" name="{{ $control_id }}_sel_model_template" class="form-select">
                                                <option value="0">None</option>
                                                @foreach($model_documents as $idx=>$model_document)
                                                @if (method_exists($model_document,'get_default_model_template'))
                                                    @php
                                                        $actual_model_document = $model_document->get_default_model_template();
                                                    @endphp
                                                    @if ($actual_model_document!=null)
                                                        <option value="{{$actual_model_document->id}}">{{$actual_model_document->documentGenerationTemplate->title}}</option>
                                                    @endif
                                                @endif
                                                @endforeach
                                            </select>
                                        @endif

                                        <div id="div-{{ $control_id }}_sel_template" class="form-group">
                                            <label for="{{ $control_id }}_sel_template" class="col-lg-12 small col-form-label fw-bold">Template</label>
                                            <select id="{{ $control_id }}_sel_template" name="{{ $control_id }}_sel_template" class="form-select">
                                                <option value="" data-val-outputs="">Select a Template</option>
                                                @foreach($templates as $template)
                                                @if ($template!=null)
                                                <option value="{{$template->id}}" data-val-outputs="{{$template->output_content_types}}">{{$template->title}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id="div-{{ $control_id }}_sel_output" class="form-group">
                                            <label for="{{ $control_id }}_sel_output" class="col-lg-12 small col-form-label fw-bold">Document Type</label>
                                            <select id="{{ $control_id }}_sel_output" name="{{ $control_id }}_sel_output" class="form-select">
                                                <option value="" data-val-outputs="">Select a File Type</option>
                                            </select>
                                        </div>

                                        <div id="div-{{ $control_id }}_file_name" class="form-group">
                                            <label for="{{ $control_id }}_file_name" class="col-lg-12 small col-form-label fw-bold">File Name</label>
                                            <input id="{{ $control_id }}_file_name" name="{{ $control_id }}_file_name" class="form-control" type="text" />
                                        </div>

                                        <div id="div-{{ $control_id }}_generate" class="form-group py-3">
                                            <button type="button" class="btn btn-primary" id="{{ $control_id }}_btn-save-document" value="add">
                                                <span class="spinner">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </span>
                                                Save Document
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">

        let pdfViewerParent = $('embed#{{$control_id}}_pdfEmbed').parent();

        function {{ $control_id }}_initiate_control() {

        }

        $(document).ready(function(){

            {{ $control_id }}_initiate_control();
            $('.spinner').hide()

            $('.{{$target_class}}').click(function(){
                $('#{{ $control_id }}_frm').trigger("reset");
                $('#{{ $control_id }}-modal').modal('show');
                $('#{{ $control_id }}_error_div').hide();

                $("#{{ $control_id }}_spinner").hide();
                $("#{{ $control_id }}_btn-start").attr('disabled', false);
            });

            function generateDocumentPreview(){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                if ($("#{{ $control_id }}_sel_template").val() != ""){

                    $('#{{ $control_id }}_error_div').empty();
                    $('#{{ $control_id }}_error_div').hide();
                    $("#{{ $control_id }}_btn-save-document").attr('disabled', true);
                    $('.spinner').show();

                    $('#{{$control_id}}_initial_notice').remove();
                    $('embed#{{$control_id}}_pdfEmbed').remove();

                    let itemId = $("#{{ $control_id }}_sel_template").val();
                    $.get("{{ route('fc-api.document_generation_templates.show','') }}/"+itemId).done(function( response ) {
                        $("#{{ $control_id }}_file_name").val(response.data.file_name_prefix);
                        $('#{{ $control_id }}_sel_output').children('option').remove();

                        output_options = response.data.output_content_types.split(",");
                        $.each(output_options, function (i, item) {
                            $('#{{ $control_id }}_sel_output').append($('<option>',{value: item, text:item}));
                        });
                        $("#{{ $control_id }}_btn-save-document").attr('disabled', false);
                        $('.spinner').hide();
                    });

                    //Generate the Document Preview
                    var doc_url = "{{ route('fc.dmgr-preview-render','') }}/"+itemId+"?mid={{$document_generator->id}}&mpe="+String.raw`{{get_class($document_generator)}}`+'&mdtid='+$("#{{$control_id}}_sel_model_template").val();
                    pdfViewerParent.append(
                        "<embed src='"+doc_url+"' id='{{$control_id}}_pdfEmbed' height='100%' width='100%' style='height:75vh'>"
                    );
                }
            }

            $(document).on('change', "#{{$control_id}}_sel_template", function(e) {
                e.preventDefault();
                generateDocumentPreview();
            });

            $(document).on('change', "#{{$control_id}}_sel_model_template", function(e) {
                e.preventDefault();
                generateDocumentPreview();
            });

            $(document).on('click', "#{{ $control_id }}_btn-save-document", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


                $("#{{ $control_id }}_spinner").show();
                $("#{{ $control_id }}_btn-save-document").attr('disabled', true);
                $('.spinner').show();

                let templateId = $("#{{ $control_id }}_sel_template").val();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', "POST");
                formData.append('templateId', templateId);
                formData.append('modelId', "{{$document_generator->id}}");
                formData.append('modelType', String.raw`{{get_class($document_generator)}}`);
                formData.append('contentType', $("#{{ $control_id }}_sel_output").val());
                formData.append('fileName', $("#{{ $control_id }}_file_name").val());
                if ($("#cbx-{{ $control_id }}_model_template")){
                    formData.append('modelDocumentId', $("#cbx-{{ $control_id }}_model_template").val());
                }
                @if (isset($organization) && $organization != null)
                formData.append('organization_id', '{{ $organization->id }}');
                @endif

                $.ajax({
                    url: "{{ route('fc.dmgr-file-save','') }}/"+templateId,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            $('#{{ $control_id }}_error_div').show();
                            $.each(result.errors, function(key, value) {
                                $('#{{ $control_id }}_error_div').append('<li class="">'+value+'</li>');
                            });
                        } else {
                            $('#{{ $control_id }}_error_div').hide();

                            swal({
                                title: "Saved",
                                text: "Document saved successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });

                            setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                        $("#{{ $control_id }}_spinner").hide();
                        $("#{{ $control_id }}_btn-save-document").attr('disabled', false);
                        $('.spinner').hide();
                    },
                    error: function(data) {
                        $("#{{ $control_id }}_spinner").hide();
                        $("#{{ $control_id }}_btn-save-document").attr('disabled', false);
                        $('.spinner').hide();
                        console.log(data);
                    }
                });
            });

        });

    </script>
    @endpush

@endif


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

                                        <div id="div-{{ $control_id }}_sel_template" class="form-group">
                                            <label for="{{ $control_id }}_sel_template" class="col-lg-12 small col-form-label fw-bold">Template</label>
                                            <select id="{{ $control_id }}_sel_template" name="{{ $control_id }}_sel_template" class="form-select">
                                                <option value="" data-val-outputs="">Select a Template</option>
                                                @foreach($templates as $template)
                                                <option value="{{$template->id}}" data-val-outputs="{{$template->output_content_types}}">{{$template->title}}</option>
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
                                            <button type="button" class="btn btn-primary" id="{{ $control_id }}_btn-start" value="add">
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

            $(document).on('change', "#{{ $control_id }}_sel_template", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let itemId = this.value;
                $.get("{{ route('fc-api.document_generation_templates.show','') }}/"+itemId).done(function( response ) {
                    $("#{{ $control_id }}_file_name").val(response.data.file_name_prefix);
                    $('#{{ $control_id }}_sel_output').children('option').remove();

                    output_options = response.data.output_content_types.split(",");
                    $.each(output_options, function (i, item) {
                        $('#{{ $control_id }}_sel_output').append($('<option>',{value: item, text:item}));
                    });
                });

                //Generate the Document Preview
                var doc_url = "{{ route('fc.dmgr-preview-render','') }}/"+itemId+"?mid={{$document_generator->id}}&mpe="+String.raw`{{get_class($document_generator)}}`;
                var parent = $('embed#{{$control_id}}_pdfEmbed').parent();
                var newElement = "<embed src='"+doc_url+"' id='pdfEmbed' height='100%' width='100%' style='height:75vh'>";

                $('#{{$control_id}}_initial_notice').remove();
                $('embed#{{$control_id}}_pdfEmbed').remove();
                parent.append(newElement);
                
            });

        });

    </script>
    @endpush

@endif
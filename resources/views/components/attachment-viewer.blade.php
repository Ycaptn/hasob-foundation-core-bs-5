
@if ($attachable!=null)

    @push('page_css')
    <style type="text/css">
        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width:1200px;
            }
        }
        #attachment-viewer-modal > .modal {
            height: 100vh;
        }
        #attachment-viewer-modal > .modal-dialog {
            height: 100vh;
        }
        #attachment-viewer-modal > .modal-content {
            height: 95vh;
        }
    </style>
    @endpush


    @php
        $attachments = $attachable->get_attachments();
    @endphp

    @if (count($attachments) > 0)

        <button class="btn btn-xs btn-danger pull-right" id="btnShowAttachmentViewer">Viewer</button>

        <div class="modal fade" id="attachment-viewer-modal" role="dialog" aria-labelledby="attachment-viewer-label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="attachment-viewer-modal-label"></h4>
                        <small id="attachment-viewer-modal-description"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <embed id="pdfEmbed" src="" width="100%" height="100%" style='height:75vh'/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-xs btn-primary pull-left" id="showPrevious"> << Previous </button>
                        <button class="btn btn-xs btn-primary" id="showNext"> Next >> </button>
                    </div>
                </div>
            </div>
        </div>

        @push('page_scripts')
        <script type="text/javascript">
            $(document).ready(function(){

                var attach_list = [];
                var attach_list_names = [];
                var attach_list_descriptions = [];
                var attach_location = 0;
                @foreach ($attachments as $idx => $attach)
                    attach_list.push("{{ route('fc.attachment.show', $attach->id) }}");
                    attach_list_names.push("{{ $attach->label  }}");
                    attach_list_descriptions.push("{{ $attach->description }}");
                @endforeach

                function displayAttachmentDetails(idx){
                    $("#attachment-viewer-modal-label").text(attach_list_names[idx]);
                    $("#attachment-viewer-modal-description").text(attach_list_descriptions[idx]);
                }

                $('#btnShowAttachmentViewer').click(function(){
                    
                    var parent = $('embed#pdfEmbed').parent();
                    var newElement = "<embed src='"+attach_list[attach_location]+"' id='pdfEmbed' height='100%' width='100%' style='height:75vh'>";

                    if (attach_list[attach_location]!=null){
                        $('embed#pdfEmbed').remove();
                        parent.append(newElement);
                        displayAttachmentDetails(attach_location);
                        $('#attachment-viewer-modal').modal('show');
                    }
                });

                $('#showNext').click(function(){
                    if (attach_location<(attach_list.length-1)){
                        var parent = $('embed#pdfEmbed').parent();
                        var newElement = "<embed src='"+attach_list[++attach_location]+"' id='pdfEmbed' height='100%' width='100%' style='height:75vh'>";
                        $('embed#pdfEmbed').remove();

                        if (attach_list[attach_location]!=null){
                            displayAttachmentDetails(attach_location);
                            parent.append(newElement);
                        }
                    }
                });

                $('#showPrevious').click(function(){
                    if (attach_location>0){
                        var parent = $('embed#pdfEmbed').parent();
                        var newElement = "<embed src='"+attach_list[--attach_location]+"' id='pdfEmbed' height='100%' width='100%' style='height:75vh'>";
                        $('embed#pdfEmbed').remove();

                        if (attach_list[attach_location]!=null){
                            displayAttachmentDetails(attach_location);
                            parent.append(newElement);
                        }
                    }
                });

            });
        </script>
        @endpush

    @endif

@endif
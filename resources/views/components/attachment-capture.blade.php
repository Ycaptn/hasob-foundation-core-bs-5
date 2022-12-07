@if ($attachable != null)
<button type="button" class="btn btn-sm btn-danger mb-2" id="{{$control_id}}_btnNewCapture" data-toggle="tooltip" title="Capture"> 
    <i class="fa fa-camera"></i> Capture
</button>

<div class="modal fade" id="{{$control_id}}_capture-modal" tabindex="-1" role="dialog" aria-labelledby="{{$control_id}}_capture-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="{{$control_id}}_capture-modal-title" class="modal-title">Capture</h4>
                <button type="button" class="btn-close close-capture-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="error_div_{{$control_id}}_capture" class="alert alert-danger" role="alert">
                    <span id="error_msg_{{$control_id}}_capture"></span>
                </div>

                <div class="row">
                    <div class="d-flex align-items-center mb-2">
                        <div>
                            <div class="{{$control_id}}_capture-area">
                                <div id="{{$control_id}}_camera"></div>
                                <div id="{{$control_id}}_snapShotArea"></div>
                                <center>
                                    <button type="button" class="btn btn-sm btn-primary m-1 px-3" id="{{$control_id}}_capture-btn"><i class="fa fa-camera"></i> Capture</button>
                                    <button type="button" class="btn btn-sm btn-primary m-1 px-3" id="{{$control_id}}_save-img-btn"><i class="fa fa-file-image-o"></i> Save Images</button>
                                    <button type="button" class="btn btn-sm btn-primary m-1 px-3" id="{{$control_id}}_save-pdf-btn"><i class="fa fa-file-pdf-o"></i> Save PDF</button>
                                </center>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <ul id="{{$control_id}}-ul-img_lister" class="list-unstyled">
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="{{$control_id}}_editor-modal" tabindex="-1" role="dialog" aria-labelledby="{{$control_id}}_editor-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="{{$control_id}}_editor-modal-title" class="modal-title">Editor</h4>
                <button type="button" class="btn-close close_editor-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="{{$control_id}}_editable_container">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="{{$control_id}}_saver-modal" tabindex="-1" role="dialog" aria-labelledby="{{$control_id}}_saver-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="{{$control_id}}_saver-modal-title" class="modal-title">Save</h4>
                <button type="button" class="btn-close close_saver-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>



@push('page_scripts')

    <script type="text/javascript" src="https://scaleflex.cloudimg.io/v7/plugins/filerobot-image-editor/latest/filerobot-image-editor.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
    <script type="text/javascript" src="https://unpkg.com/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            window.jsPDF = window.jspdf.jsPDF;
            let image_store = [];

            $('#{{$control_id}}_btnNewCapture').click(function() {
                $('#error_div_{{$control_id}}_capture').hide();
                
                navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
                navigator.getMedia({video: true}, function() {
                        $('#{{$control_id}}_capture-modal').modal('show');
                    }, function() {
                        alert("No Camera");
                    }
                );

                Webcam.set({
                    width: 528,
                    height: 380,
                    dest_width: 640,
                    dest_height: 480,
                    image_format: 'jpeg',
                    jpeg_quality: 100
                });
            
                Webcam.attach('#{{$control_id}}_camera');
            });

            $('.close-capture-modal').click(function() {
                $('#{{$control_id}}_capture-modal').modal('hide');
                location.reload(true);
            });

            $(document).on('click', '#{{$control_id}}_capture-btn', function(e) {
                e.preventDefault();
                $('#error_div_{{$control_id}}_capture').fadeOut(300);
                captureImage();
            })

            function captureImage() {
                Webcam.snap(function (data_uri) {
                    //$('#{{$control_id}}_capture-btn').text('Capture');
                    image_store.push(data_uri);
                    listCapturedImages();
                });
            }

            function listCapturedImages(){
                $('#{{$control_id}}-ul-img_lister').empty();
                $.each(image_store, function(key,item){
                    $('#{{$control_id}}-ul-img_lister').append(
                        `<li class="d-flex align-items-center border-bottom pb-2">
                            <div class="product-box">
                                <img src="`+item+`"/>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="fwt-bold mt-0 mb-0">Page `+(key+1)+`</p>
                                <a href="#" class="{{$control_id}}_edit-btn" data-val="`+key+`" data-img="`+item+`"><i class="bx bx-edit"></i></a>
                                <a href="#" class="{{$control_id}}_delete-btn" data-val="`+key+`"><i class="bx bx-trash"></i></a>
                            </div>
                        </li>`
                    );
                });
            }

            $(document).on('click', '.{{$control_id}}_delete-btn', function(e) {
                image_store.splice($(this).attr('data-val'), 1);
                listCapturedImages();
            });

            $(document).on('click', '.{{$control_id}}_edit-btn', function(e) {
                let editorConfig = {
                    source: $(this).attr('data-img'),
                    onSave: function(editedImageObject, designState) {
                        image_store[$(this).attr('data-val')] = designState.imageBase64;
                        listCapturedImages();
                    }.bind(this, image_store),
                    annotationsCommon: {fill: '#ff0000'},
                    Text: { text: 'Filerobot...' },
                    Rotate: { angle: 90, componentType: 'slider' },
                    translations: {
                        profile: 'Profile',
                        coverPhoto: 'Cover photo',
                        facebook: 'Facebook',
                        socialMedia: 'Social Media',
                        fbProfileSize: '180x180px',
                        fbCoverPhotoSize: '820x312px',
                    },
                    Crop: {
                        presetsItems: [
                            {
                                titleKey: 'classicTv',
                                descriptionKey: '4:3',
                                ratio: 4 / 3,
                                // icon: CropClassicTv, // optional, CropClassicTv is a React Function component. Possible (React Function component, string or HTML Element)
                            },
                            {
                                titleKey: 'cinemascope',
                                descriptionKey: '21:9',
                                ratio: 21 / 9,
                                // icon: CropCinemaScope, // optional, CropCinemaScope is a React Function component.  Possible (React Function component, string or HTML Element)
                            },
                        ],
                        presetsFolders: [{}],
                    },
                    //tabsIds: [window.FilerobotImageEditor.TABS.ADJUST, window.FilerobotImageEditor.TABS.ANNOTATE, window.FilerobotImageEditor.TABS.WATERMARK], // or ['Adjust', 'Annotate', 'Watermark']
                    tabsIds: [window.FilerobotImageEditor.TABS.ADJUST],
                    defaultTabId: window.FilerobotImageEditor.TABS.ADJUST, // or 'Annotate'
                    defaultToolId: window.FilerobotImageEditor.TOOLS.TEXT, // or 'Text'
                };

                let filerobotImageEditor = new FilerobotImageEditor(
                    document.querySelector('#{{$control_id}}_editable_container'), editorConfig
                );

                filerobotImageEditor.render({
                    onClose: (closingReason) => {
                        console.log('Closing reason', closingReason);
                        filerobotImageEditor.terminate();
                    }
                });

                $('#{{$control_id}}_editor-modal').modal('show');
            });

            function b64toBlob(fileName, dataURI, mimeType) {
                var byteString = atob(dataURI.split(',')[1]);
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);
                
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                var finalBlob = new Blob([ab], { type: mimeType });
                finalBlob.lastModifiedDate = new Date();
                finalBlob.name = fileName;

                return finalBlob;
            }

            function saveAttachable(file_name, blob){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                var formData = new FormData();
                formData.append('options', JSON.stringify({
                    'name': file_name,
                    'attachable_id': '{{ $attachable->id }}',
                    'attachable_type':  String.raw`{{ get_class($attachable) }}`,
                }));
                formData.append('file', blob);

                $.ajax({
                    url: "{{ route('fc.attachment.store') }}",
                    type: "POST",
                    data: formData, 
                    processData: false,
                    contentType: false,
                    success: function(result){},
                });
            }

            $(document).on('click', '#{{$control_id}}_save-img-btn', function(e) {
                $.each(image_store, function(key,item){
                    var file = new File([b64toBlob("Image"+(key+1)+".jpg", item, 'image/jpeg')], "Image"+(key+1)+".jpg", {type: "image/jpeg", lastModified: new Date()});
                    saveAttachable("Image"+(key+1), file);
                });
            });

            $(document).on('click', '#{{$control_id}}_save-pdf-btn', function(e) {
                let pdf = new jsPDF();
                $.each(image_store, function(key,item){
                    pdf.addImage(item, 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
                    if(key<(image_store.length-1)){ pdf.addPage(); }
                });
                //pdf.save("index.pdf");
                var file = new File([pdf.output('blob', "filename.pdf")], "filename.pdf", {type: "application/pdf", lastModified: new Date()});
                saveAttachable("PDF File", file);
            });

        });

    </script>
@endpush

@endif
@if ($attachable != null)
<button type="button" class="btn btn-sm btn-danger mb-2" id="{{$control_id}}_btnNewCapture" data-toggle="tooltip" title="Capture"> 
    <i class="fa fa-camera"></i> Capture
</button>

<div class="modal fade" id="{{$control_id}}_capture-modal" tabindex="-1" role="dialog" aria-labelledby="{{$control_id}}_capture-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="{{$control_id}}_capture-modal-title" class="modal-title">Capture</h4>
                <button type="button" class="btn-close close-capture-modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="error_div_{{$control_id}}_capture" class="alert alert-danger" role="alert">
                    <span id="error_msg_{{$control_id}}_capture"></span>
                </div>

                <div class="capture-error hide-cont" role="alert">
                    Unable to capture image. Please pick a brighter spot to continue.<br><br>
                </div>
                <div class="{{$control_id}}_capture-area">
                    <div id="{{$control_id}}_camera"></div>
                    <div id="{{$control_id}}_snapShotArea"></div>
                    <button type="button" class="btn btn-xs btn-primary" id="{{$control_id}}_capture-btn" value="add">Capture</button>
                </div>

            </div>

        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
    <script type="text/javascript" src="https://unpkg.com/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            $('#{{$control_id}}_btnNewCapture').click(function() {
                $('#error_div_{{$control_id}}_capture').hide();
                
                navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
                navigator.getMedia({video: true}, function() {
                        //Webcam is available
                        $('#{{$control_id}}_capture-modal').modal('show');
                    }, function() {
                        alert("No Camera");
                    }
                );

                // CAMERA SETTINGS.
                Webcam.set({
                    width: 420,
                    height: 320,
                    image_format: 'jpeg',
                    jpeg_quality: 100
                });
            
                Webcam.attach('#{{$control_id}}_camera');
            });

            $('.close-capture-modal').click(function() {
                $('#{{$control_id}}_capture-modal').modal('hide');
                location.reload(true);
            });

            let tries = 0;


            $(document).on('click', '#{{$control_id}}_capture-btn', function(e) {
                e.preventDefault();
                tries++
                $(this).text('Capturing...');
                $('.capture-error').fadeOut(300);
                captureImage();
            })

            function captureImage() {
                Webcam.snap(function (data_uri) {
                    detectFace(data_uri);
                });
            }

            async function detectFace(data_uri){
                
                const image = new Image();
                image.src= data_uri;
                await faceapi.nets.tinyFaceDetector.loadFromUri('/face-models-service');
                
                //const landmarks = await faceapi.detectAllFaces(image, new faceapi.TinyFaceDetectorOptions()).withLandmarks();
                const faces = await faceapi.detectAllFaces(image, new faceapi.TinyFaceDetectorOptions());
                    
                // console.log(faces);

                if (faces.length === 0 && tries <= 2) {
                console.log("no face detected");
                $('#capture-btn').text('Capture');
                $('.capture-error').html(' Unable to capture image. Please pick a brighter spot to continue.').fadeIn(300);
                }else if(faces.length === 0 && tries > 2){
                    sendPicture(data_uri);
                }
                if(faces.length > 1){
                    console.log("multiple faces detected");
                    $('#capture-btn').text('Capture');
                    $('.capture-error').html('Unable to process. Multiple faces detected.').fadeIn(300);
                }
                if (faces.length === 1){
                    if(faces[0]._score < 0.4 || tries > 2){
                        //console.log("image quality is low");
                        sendPicture(data_uri);
                    }else if(faces[0]._score > 0.4){
                        console.log("image quality is good ");

                        sendPicture(data_uri);
                    }
                // console.log("face detected"); 
                }
            }

            function sendPicture(data_uri) {
                // console.log(data_uri);
                // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                // let actionType = "POST";
                // let endPointUrl = $("input[name='save_url']").val();;
                // join_url = $("input[name='join_url']").val();

                // let formData = new FormData();
                // formData.append('student_img', data_uri);
                // document.getElementById('snapShotArea').innerHTML = 
                // '<br><img src="' + data_uri + '" width="70px" height="50px" />';
                // $.ajax({
                //     url:endPointUrl,
                //     type: "POST",
                //     data: formData, 
                //     cache: false,
                //     processData:false, 
                //     contentType: false,
                //     dataType: 'json',
                //     success: function(result){
                //         $('#capture-btn').text('Redirecting...');
                //         window.open(join_url, "_blank");
                //     },
                // });
            } 



        });

    </script>
@endpush

@endif
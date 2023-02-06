@php
$current_user = Auth::user();
@endphp


<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body">

        <div class="d-flex flex-column align-items-center text-center">

            <button id="btn-profilePicBtn" class="position-absolute top-0 end-0 btn btn-sm btn btn-outline-primary mt-1 me-2 py-0 px-1 small"><small>Change</small></button>
            

            @if ( $current_user->profile_image == null )
                <img style="max-width:110px;" class="rounded-circle p-1 bg-primary" src="../imgs/bare-profile.png" alt="Change your Profile Picture">
            @else
                <img style="max-width:110px;" class="rounded-circle p-1 bg-primary" src="{{ route('fc.get-profile-picture', $current_user->id) }}" alt="Change your Profile Picture">
            @endif


            <input id="file-profilePic" class="upload" type="file" style="display:none;">

            <div class="mt-3">
                <h4>{{ $current_user->full_name }}</h4>
                <p class="text-secondary mb-1">
                    @php
                        $title_dept = [];
                        if (!empty($current_user->job_title)){
                            $title_dept []= $current_user->job_title;
                        }
                        if ($current_user->department != null && !empty($current_user->department->name)){
                            $title_dept []= $current_user->department->name;
                        }
                    @endphp

                    {{ implode(" | ", $title_dept) }}
                </p>
            </div>
        </div>
        <hr class="my-1" />
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center flex-wrap p-1">
                @php
                    $userRoles = $current_user->getRoleNames();
                @endphp
                @foreach ($userRoles as $idx=>$roleName)
                    <span class="mb-1 badge bg-primary fw-normal me-2">{!! $roleName !!}</span>
                @endforeach
            </li>
            @if (FoundationCore::has_feature('signatures', $organization))
                <li class="list-group-item d-flex align-items-center justify-content-between flex-wrap p-1">
                    @if($current_user->signature != null)
                        <img 
                            id="current_signatory_image" 
                            name="current_signatory_image" 
                            width="100px" 
                            height="50px" 
                            src=""
                            alt="signature"
                        />
                        <button id="btn-signatureBtn" class="btn btn-sm btn btn-outline-primary mt-1 me-2 py-0 small">
                            <small>
                                Change
                            </small>
                        </button>
                    @else
                        <p class="d-flex text-danger align-items-center">No Signature set</p>
                        <button id="btn-signatureBtn" class="btn btn-sm btn btn-outline-primary mt-1 me-2 py-0 small">
                            <small>
                                Upload
                            </small>
                        </button>
                    @endif
                </li>
                <input id="file-signaturePic" class="upload" type="file" style="display:none;">
            @endif

            @if (isset($current_user->website_url) && empty($current_user->website_url)==false)
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                </h6>
                <span class="text-secondary">{{ $current_user->website_url }} </span>
            </li>
            @endif
        </ul>
    </div>
    <div class="card-footer bg-white text-center"> 
        <small class="text-muted">
            @if ($current_user->last_loggedin_at != null)
                Last logged in {{$current_user->last_loggedin_at->diffForHumans()}}
            @else
                Never Logged in.
            @endif
        </small>
    </div>
</div>



@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function(){

        function getSignatureimage(){
            let primaryId = "{{$current_user->signature != null ? $current_user->signature->id : '' }}";
            
            if(primaryId !== ''){
                $('#current_signatory_image').attr('src', "{{route('fc.signature.view-item', '')}}/" + primaryId);
                $('#current_signatory_image').show();
            }

        }

        getSignatureimage();

        $('#btn-profilePicBtn').on('click', function() {
            $('#file-profilePic').trigger('click');
        });

        
        $('#btn-signatureBtn').on('click', function() {
            $('#file-signaturePic').trigger('click');
        });

        $('#btnPresence').click(function(){

            $('#error_div_availability').hide();
            $('#spinner').hide();
       
            $('#frm_availability').trigger("reset");
            $('#availability-modal').modal('show');
        });

        $('#attach-image').click(function(){
            $('#error_div_attachment').hide();
            $('#upload-form').trigger("reset");
            $('#attachment-modal').modal('show');

            $('#div_attachment_comments').hide();
            $('#div_attachment_file_name').hide();
            $('#attachment-modal-label').html('Upload Profile Picture');
            $('#spinner').show();
            $('#save').attr("disabled", true);
        });

        $("#file-profilePic").change(function(e){
            if (confirm('Are you sure you want to upload this file?')){

                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);

                $.ajax({
                    url: "{{ route('fc.upload-profile-picture') }}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data){

                        if (data!=null && data.status=='fail'){
                            
                            alert('An error has occurred while uploading the file.');
                            console.log(data);
                                
                        }else if (data!=null && data.status=='ok'){
                            alert("File uploaded.")
                            location.reload();

                        }else{
                            alert('An error has occurred while uploading file.');
                        }
                    },
                    error: function(data){
                        console.log(data);
                        $('#spinner').hide();
                        $('#save').attr("disabled", false);
                    }
                });
            }
        });

        //upload Signature 
        $("#file-signaturePic").change(function(e){
            if (confirm('Are you sure you want to upload this file?')){

                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.signatures.store') }}";
                
                let staff_name = "{{ $current_user->full_name  }}";
                let staff_title = "{{ $current_user->job_title  }}";
                let owner_user_id = "{{ $current_user->id  }}";

                let signatureId = "{{ $current_user->signature != null ? $current_user->signature->id : '0'}}";
                
                var formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                
                if (signatureId != "0") {
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc-api.signatures.update', '') }}/" + signatureId;
                    formData.append('id', signatureId);
                }

                formData.append('_method', actionType);

                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif
                formData.append('staff_name', staff_name);
                formData.append('staff_title', staff_title);
                formData.append('owner_user_id', owner_user_id);
                let file = $('#file-signaturePic');
                console.log(file)
                formData.append('signature_image', file[0].files[0]);

                $.ajax({
                    url: endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data, "response")
                        if (data.errors) {
                            $.each(result.errors, function(key, value) {
                                alert(value);
                            });
                             
                        }else{
                            alert("File uploaded.")
                            location.reload();

                        }
                    },
                    error: function(data){
                        console.log(data);
                        $('#spinner').hide();
                        $('#save').attr("disabled", false);
                    }
                });
            }
        });


        $("#btn-add-attachment").click(function(e){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            e.preventDefault();

            var formData = new FormData();
            formData.append('file', $('#upload-form')[0][3].files[0]);

            $.ajax({
                url: "{{ route('fc.upload-profile-picture') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data){

                    if (data!=null && data.status=='fail'){
                        $('#error_div_attachment').show();
                        if (data.response!=null){
                            for (x in data.response) {
                                if ($.isArray(data.response[x])){
                                    $('#error_msg_attachment').html('<strong>Errors</strong><br/>'+data.response[x].join('<br/>'));
                                }else{
                                    $('#error_msg_attachment').html('<strong>Errors</strong><br/>'+data.response[x]);
                                }
                            }
                        } else {
                            $('#error_msg_attachment').html('<strong>Error</strong><br/>An error has occurred.');
                        }
                    }else if (data!=null && data.status=='ok'){
                        alert("File uploaded.")
                        location.reload();
                    }else{
                        $('#error_msg_attachment').html('<strong>Error</strong><br/>An error has occurred.');
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

    });
</script>
@endpush

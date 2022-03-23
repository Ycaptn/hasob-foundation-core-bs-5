@php
$current_user = Auth::user();
@endphp



<div class="card card-default card-view  pa-0">
    <div class="card-wrapper collapse in">
        <div class="card-body  pa-0">
            <div class="profile-box">
                <div class="profile-cover-pic">
                    <div class="profile-image-overlay"></div>
                </div>
                <div class="profile-info text-center">
                    <div class="profile-img-wrap">
                                                
                        @if ( $current_user->profile_image == null )
                            <img class="inline-block mb-10" src="../imgs/bare-profile.png" alt="Change your Profile Picture">
                        @else
                            <img class="inline-block mb-10" src="{{ route('fc.get-profile-picture', $current_user->id) }}" alt="Change your Profile Picture">
                        @endif

                        <div class="fileupload btn btn-default">
                            <span class="btn-text">edit</span>
                            <input class="upload" type="file">
                        </div>
                    </div>	
                    <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-primary">{{ $current_user->full_name }}</h5>
                    <h6 class="block capitalize-font pb-20">

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

                    </h6>
                </div>	

                <div class="social-info">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            @php
                                $userRoles = $current_user->getRoleNames();
                            @endphp
                            @foreach ($userRoles as $idx=>$roleName)
                            <span class="label label-primary">{!! $roleName !!}</span>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>



@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function(){

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

        $("input[type=file]").change(function(e){
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

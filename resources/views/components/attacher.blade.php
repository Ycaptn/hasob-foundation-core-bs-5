@if ($attachable!=null)
   
    <a id="{{$control_id}}_btn_attach" href="#" 
        data-val-attachble-id="{{$attachable->id}}"
        data-val-attachble-name="{{$attachment_label}}"
        data-val-attachble-class="{{get_class($attachable)}}"
        style="font-size:80%" class="ms-auto small btn-show-attacher-upload {{$button_class}}">
        {{$button_label}}
    </a>

    <div class="modal fade" id="{{$control_id}}_attacher-modal" tabindex="-1" role="dialog" aria-labelledby="attacher-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="attacher-modal-label">Attach File</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                <div id="{{$control_id}}_error_div_attacher" class="alert alert-danger" role="alert">
                    <span id="{{$control_id}}_error_msg_attacher"></span>
                </div>

                <form class="form-horizontal" id="{{$control_id}}_upload-form" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <input id="{{$control_id}}_attacher_attachble_id" type="hidden" value=""/>
                    <input id="{{$control_id}}_attacher_attachble_class" type="hidden" value=""/>
                    <input id="{{$control_id}}_attacher_attachble_name" type="hidden" value=""/>

                    <div class="mb-3">
                    <label class="form-label">Upload File</label>
                        <input class='form-control' type="file" name="image">
                    </div>
                </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="{{$control_id}}_btn-add-attacher" value="add">
                        <span id="{{$control_id}}_spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>Upload</button>
                </div>
            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#{{$control_id}}_btn-add-attacher span').hide();

            $('.btn-show-attacher-upload').click(function(e){
                $('#{{$control_id}}_error_div_attacher').hide();
                $('#{{$control_id}}_upload-form').trigger("reset");
                $('#{{$control_id}}_attacher-modal').modal('show');

                $('#{{$control_id}}_attacher_attachble_id').val($(this).attr('data-val-attachble-id'));
                $('#{{$control_id}}_attacher_attachble_name').val($(this).attr('data-val-attachble-name'));
                $('#{{$control_id}}_attacher_attachble_class').val($(this).attr('data-val-attachble-class'));
            });

            $("#{{$control_id}}_btn-add-attacher").click(function(e){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                $('#{{$control_id}}_btn-add-attacher span').show();
                $('#{{$control_id}}_btn-add-attacher').attr('disabled',true);

                var formData = new FormData();
                formData.append('file', $('#{{$control_id}}_upload-form')[0][4].files[0]);
                options = JSON.stringify({
                    'name': $('#{{$control_id}}_attacher_attachble_name').val(),
                    'attachable_id': $('#{{$control_id}}_attacher_attachble_id').val(),
                    'attachable_type': String.raw`{{get_class($attachable)}}`,
                });
                formData.append('options', options);

                $.ajax({
                    url: "{{ route('fc.attachment.store') }}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data){
                        if (data!=null && data.status=='fail'){
                            $('#{{$control_id}}_error_div_attacher').show();
                            if (data.response!=null){
                                for (x in data.response) {
                                    if ($.isArray(data.response[x])){
                                        $('#{{$control_id}}_error_msg_attacher').html('<strong>Errors</strong><br/>'+data.response[x].join('<br/>'));
                                    }else{
                                        $('#{{$control_id}}_btn-add-attacher').attr('disabled',false);
                                        $('#{{$control_id}}_error_msg_attacher').html('<strong>Errors</strong><br/>'+data.response[x]);
                                    }
                                }
                            } else {
                                $('#{{$control_id}}_btn-add-attacher span').hide();
                                $('#{{$control_id}}_btn-add-attacher').attr('disabled',false);
                                $('#{{$control_id}}_error_msg_attacher').html('<strong>Error</strong><br/>An error has occurred.');
                            }
                        }else if (data!=null && data.status=='ok'){
                             swal({
                                title: "Saved",
                                text: "File Uploaded",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });
                            window.setTimeout(function(){
                                location.reload(true);
                            }, 1000);
                        }else{
                            $('#{{$control_id}}_btn-add-attacher span').hide();
                            $('#{{$control_id}}_btn-add-attacher').attr('disabled',false);
                            $('#{{$control_id}}_error_msg_attacher').html('<strong>Error</strong><br/>An error has occurred.');
                        }
                    },
                    error: function(data){
                        $('#{{$control_id}}_btn-add-attacher span').hide();
                        $('#{{$control_id}}_btn-add-attacher').attr('disabled',false);
                        console.log(data);
                    }
                });
            });

        });
    </script>
    @endpush

@endif
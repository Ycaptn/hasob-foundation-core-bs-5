@if ($commentable != null)

    <div id="comment-form" >

        {{ csrf_field() }}
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-comments-o"></span></span>
            <input id="{{ isset($comment_tag_id)?$comment_tag_id:'comment-text'}}" 
                    type="text" class="form-control input-sm" 
                    placeholder="Type in your comments and press enter to save comments"
            />
        </div>

    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $("#comment-text").on('keypress', function(e){
                if (e.which==13 && $('#comment-text').val().length > 2){
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                    e.preventDefault();
                    let spinner = '<div class="loader2" id="loader-1"></div>';
                    var formData = new FormData();
                    options = JSON.stringify({
                        'commentable_id': '{{ $commentable->id }}',
                        'commentable_type':  String.raw`{{ get_class($commentable) }}`,
                        'comments':$('#comment-text').val(),
                    });
                    formData.append('options', options);
                    swal({
                        html: true,
                        title: 'Submitting Post Please Wait!',
                        text:  spinner,
                        showCancelButton: false, 
                        showConfirmButton: false
                    });

                    $.ajax({
                        url: "{{ route('fc.comment-add') }}",
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(data){
                            swal.close();
                            if (data!=null && data.status=='fail'){
                                if (data.response!=null){     
                                    alert("Error submitting comments "+data.response);
                                }
                            }else if (data!=null && data.status=='ok'){
                                setTimeout(() => {
                                    alert("Comments have been saved.");
                                    location.reload();
                                }, 1000);
                                
                            }else{
                                alert("Error submitting comments");
                            }
                        },
                        error: function(data){
                            swal.close();
                            console.log(data);
                        }
                    });
                }
            });

        });
    </script>
    @endpush

@endif
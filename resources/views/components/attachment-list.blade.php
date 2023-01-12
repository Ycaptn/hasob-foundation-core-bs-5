@if ($attachable!=null)

    @php
        $attachable_items = $attachable->get_attachables($file_types);
    @endphp

    @if (count($attachable_items)>0)
        <div class="offline-flag"><span class="offline-{{$control_id}}">You are currently offline</span></div>
        <div class="list-group mt-3">
        @foreach ($attachable_items as $idx => $attachable_item)
            <div class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <a href="{{ route('fc.attachment.show', $attachable_item->attachment_id) }}" target="_blank">
                        <i class="fa fa-paperclip fa-2x"></i>
                    </a>
                    <div class="flex-grow-1 ms-3">                        
                        <p class="mt-0 mb-0 text-primary">
                            <a href="{{ route('fc.attachment.show', $attachable_item->attachment_id) }}" target="_blank">
                                {{ \Illuminate\Support\Str::limit($attachable_item->attachment->label,45,'') }}
                            </a>
                            @if (Auth::id() == $attachable_item->user_id || Auth()->user()->hasAnyRole(['admin'])) 
                            <a href="#" class="{{$control_id}}_btn-delete-attachment" data-val='{{$attachable_item->id}}'>
                                <i class="bx bx-x text-danger ms-1 me-1"></i>
                            </a>
                            @endif
                        </p>
                        <p class="mb-1">
                            @if (empty($attachable_item->attachment->description) == false)
                                <small>{{ $attachable_item->attachment->description }}</small><br/>
                            @endif
                            <small class="text-muted">
                                <small><i class="fa fa-upload"></i> {{$attachable_item->user->full_name}} on {{$attachable_item->getCreateDateString()}}</small>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @else
        <div class="text-center">No Files</div>
    @endif

    
    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('.offline-{{$control_id}}').hide();

            $(document).on('click', ".{{ $control_id }}_btn-delete-attachment", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                //check for internet status 
                if (!window.navigator.onLine) {
                    $('.offline-{{$control_id}}').fadeIn(300);
                    return;
                }else{
                    $('.offline-{{$control_id}}').fadeOut(300);
                }

                let itemId = $(this).attr('data-val');
                swal({
                        title: "Are you sure you want to delete this attachment?",
                        text: "You will not be able to recover this attachment if deleted.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            let endPointUrl = "{{ route('fc-api.attachables.destroy','') }}/"+itemId;
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
                                        swal({
                                                title: "Deleted",
                                                text: "Deleted successfully",
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

        });
    </script>
    @endpush


@endif
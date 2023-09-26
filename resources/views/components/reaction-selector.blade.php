@once
    <div id="div-reaction-modal-error"></div>
@endonce
    
@if (isset($reactionable) && $reactionable!=null)
    <a href="#" class="btn-reaction-like" data-val-id="{{$reactionable->id}}" data-val-type="{{get_class($reactionable)}}">
        <i class="{{$selectorIcon}}"></i>
    </a>
@endif

@once
    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            function applyReaction(liked, reactionableItemId, reactionableItemType){
                @if($canSelect)
                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('reactionable_id', reactionableItemId);
                    formData.append('reactionable_type', reactionableItemType);
                    formData.append('creator_user_id',"{{ Auth::id() }}");
                    formData.append('client_ip_address', "{{request()->ip()}}");
                    formData.append('client_user_agent_string', "{{ request()->server('HTTP_USER_AGENT'); }}");

                    if (liked==true){ formData.append('is_liked', 1); }
                    if (liked==false){ formData.append('is_not_liked', 1); }

                    @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                    @endif

                    $.ajax({
                        url: "{{route('fc-api.reactions.store')}}",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result) {                                
                            if (result.errors) {
                                $('#div-reaction-modal-error').html('');
                                $('#div-reaction-modal-error').show();
                                $.each(result.errors, function(key, value) {
                                    $('#div-reaction-modal-error').append('<li class="alert alert-danger" role="alert">' + value + '</li>');
                                });
                            } else {
                                $('#div-reaction-modal-error').hide();
                                swal({
                                    title: "Thank you.",
                                    text: "Your Like has been Saved.",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                                window.setTimeout(function(){
                                    location.reload(true);
                                },1000);
                            }
                        },
                        error: function(data) {
                            $('#div-reaction-modal-error').hide();
                            console.log(data);
                        }
                    });
                @endif
            }

            //Save Like Reaction
            $('.btn-reaction-like').click(function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let reactionableItemId = $(this).attr('data-val-id');
                let reactionableItemType = $(this).attr('data-val-type');
                applyReaction(true, reactionableItemId, reactionableItemType);
            });

            //Save DisLike Reaction
            $('.btn-reaction-dislike').click(function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let reactionableItemId = $(this).attr('data-val-id');
                let reactionableItemType = $(this).attr('data-val-type');
                applyReaction(false, reactionableItemId, reactionableItemType);
            });

        });
    </script>
    @endpush
@endonce
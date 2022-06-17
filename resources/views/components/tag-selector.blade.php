@if ($taggable!=null)

    @php
        $tags = $taggable->tags();
    @endphp

    <div class="mt-3 mb-5">
        <label class="form-label">Select Tags or Enter a New Tag</label>
        <select id="{{$control_id}}" name="{{$control_id}}[]" class="form-select" style="width: 100%" placeholder="Select a Tag" multiple aria-label="Select a Tag">
            @foreach($possible_tags as $possible_tag)
            @if($possible_tag != null)
                <option selected="{{$possible_tag->id}}" value="{{$possible_tag->id}}">{{$possible_tag->name}}</option>
            @endif
            
            @endforeach
        </select>
    </div>

    @push('page_css')
    @endpush

    @push('page_scripts')
    <script type="text/javascript">
            
        function save_tag(e, taggable_func) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', "POST");
            formData.append('name', e.params.data.text);
            @if (isset($organization) && $organization!=null)
                formData.append('organization_id', '{{$organization->id}}');
            @endif

            $.ajax({
                url:"{{ route('fc-api.tags.store') }}",
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                    }else{
                        taggable_func(e,result.data);
                         swal({
                                title: "Saved",
                                text: "Tag saved successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })

                            setTimeout(function() {
                             location.reload(true);
                            }, 1000);
                    }
                }, error: function(data){
                    swal("Error", "Oops an error occurred. Please try again.", "error");
                }
            });
        };

        function save_taggable(e, tag){
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', "POST");
            formData.append('tag_id', tag.id);
            formData.append('taggable_id', '{{$taggable->id}}');
            formData.append('taggable_type', String.raw`{{ get_class($taggable) }}`);
            @if (isset($organization) && $organization!=null)
                formData.append('organization_id', '{{$organization->id}}');
            @endif

            $.ajax({
                url:"{{ route('fc-api.taggables.store') }}",
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    console.log(result);

                }, error: function(data){
                    console.log(data);
                }
            });
        }

        $(document).ready(function() {
            $("select[id='{{$control_id}}']").css('width', '100%');
            $("select[id='{{$control_id}}']").select2({
                theme: "classic",
                width: 'resolve',
                tags: [],
                tokenSeparators: [","," "],
                allowClear: true,
            })

            $("select[id='{{$control_id}}']").on('select2:select', function (e){
                save_tag(e, save_taggable);
            });

            $("select[id='{{$control_id}}']").on('select2:unselect', function (e){
                let data = e.params.data;
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                
                 let itemId =data.id;
        
                        swal({
                            title: "Are you sure you want to remove this tag?",
                        text: "You will not be able to recover this tag record if removed.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                        },function(isConfirm){
                            if(isConfirm){

                                let endPointUrl = "{{route('fc-api.tags.destroy','')}}/" + itemId;
                                let formData = new FormData();
                                formData.append('_token', $('input[name="_token"]').val());
                                formData.append('_method','DELETE');

                                $.ajax({
                                    url:endPointUrl,
                                    type:'POST',
                                    data:formData,
                                    cache:false,
                                    processData:false,
                                    contentType:false,
                                    dataType:'json',
                                    success:function(result){
                        
                                        if(result.errors){
                                            console.log(result.errors);
                                        }else{
                                            swal({
                                            title: "Deleted",
                                            text: "The tag record has been deleted.",
                                            type: "success",
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false
                                        })
                                        setTimeout(function() {
                                            location.reload(true);
                                        }, 1000);
                                        }
                                    }
                                })
                            }
                        })
                    
            });
        });

    </script>
    @endpush

@endif
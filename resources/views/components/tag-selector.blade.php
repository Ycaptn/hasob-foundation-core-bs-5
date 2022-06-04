@if ($taggable!=null)

    @php
        $tags = $taggable->tags();
    @endphp

    <div class="mt-3 mb-5">
        <label class="form-label">Select Tags or Enter a New Tag</label>
        <select id="{{$control_id}}" name="{{$control_id}}[]" class="form-control" style="width: 100%" placeholder="Select a Tag" multiple="multiple">
            @foreach($possible_tags as $possible_tag)
            <option value="{{$possible_tag->name}}">{{$possible_tag->name}}</option>
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
                        swal("Success", "Tag saved.", "success");
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
            });

            $("select[id='{{$control_id}}']").on('select2:select', function (e){
                save_tag(e, save_taggable);
            });

            $("select[id='{{$control_id}}']").on('select2:unselect', function (e){
                var data = e.params.data;
                //alert(data.text);
                //AJAX call to remove the tag from the taggable object

            });
        });

    </script>
    @endpush

@endif
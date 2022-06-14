@if (isset($ratable) && $ratable!=null)
  
    @php
        $ratableType = str_replace('\\', '\\', get_class($ratable));
    @endphp
  <div id="div-rating-modal-error" type='visually-hidden' class="alert alert-danger" role="alert"></div> 
<div id='ratingDiv'>
        <a  href="#" 
            title="Rating 1" 
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="1"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{$ratableType}}">
            <i id="btn-{{$control_id}}-0" class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 2" 
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="2"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{$ratableType}}">
            <i id="btn-{{$control_id}}-1" class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 3" 
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="3"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{$ratableType}}"
            >
            <i id="btn-{{$control_id}}-2" class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 4" 
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="4"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{$ratableType}}">
            <i id="btn-{{$control_id}}-3" class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 5" 
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="5"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{$ratableType}}">
            <i id="btn-{{$control_id}}-4" class="bx bx-star font-20 email-star"></i>
        </a>
        <input type="hidden" name="ratingId" id="ratingId" value='0'>
</div>

@endif


@once

    @push('page_scripts')
    <script type="text/javascript">
        
        $(document).ready(function(){
             $('#div-rating-modal-error').hide();
             $('#div-rating-modal-error').html('');

            let rat_id = "{{$ratable->id}}";

            getStarRating();

            //fetch star ratings
            function getStarRating(){
                $.get("{{ route('fc-api.ratings.index', '') }}?ratable_id=" + rat_id).done(function(response) {
                    if(response.data.length > 0){
                        $('#ratingId').val(response.data[0].id);
                       let stars = response.data[0].score
                        for(let i=0;i < stars; i++){
                    $('#btn-{{$control_id}}-'+i).addClass('bx bxs-star font-20 email-star');
                   
                  
                }
                   }
                });
            }
            
            //star rating mouseover and mouseout
            $('.btn-rating-select').on('mouseover',function(){
                let onStar = parseInt($(this).data('val-score'))

                $(this).parent().children('a.btn-rating-select').each(function(e){
                    if(e < onStar){
                        $(this).find('i').addClass('text-primary')
                    }else{
                        $(this).find('i').removeClass('text-primary')
                    }
                })
            }).on('mouseout',function(){
                 $(this).parent().children('a.btn-rating-select').each(function(e){
                       $(this).find('i').removeClass('text-primary')
                })
            })
             
            //Save details
            $('.btn-rating-select').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                
                $('#div-rating-modal-error').hide();
                let onStar = parseInt($(this).data('val-score'))
                let stars = $(this).parent().children('a.btn-rating-select')
                for(let i=0;i < stars.length; i++){
                $(stars[i]).html('<i class="bx bx-star font-20 email-star"></i>')
                  
                }
                for(let i=0;i < onStar; i++){
                    $(stars[i]).html('<i class="bx bxs-star font-20 email-star"></i>');
                }
                 
                let actionType ="POST";
                let endPointUrl = "{{ route('fc-api.ratings.store')}}";
                let itemId = $(this).attr('data-val-id');
                let ratingType = $(this).attr('data-val-type');
                let ratingScore = $(this).attr('data-val-score');
                let ratingId = $('#ratingId').val();
                
                 let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                /*commented code is for the update functionality which gives error when uncommented
                still working on it
                */
            //    if (ratingId === '0') {
            //         actionType = "PUT";
            //         endPointUrl = "{{ route('fc-api.ratings.update','') }}/"+itemId;
            //         formData.append('id', ratingId);
            //     } 
                 formData.append('_method', actionType);
                 formData.append('ratable_id', itemId);
                 formData.append('ratable_type', ratingType);
                 formData.append('score', ratingScore);
                   formData.append('creator_user_id',"{{ Auth::id() }}");
                 @if (isset($organization) && $organization != null)
                        formData.append('organization_id', '{{ $organization->id }}');
                @endif

               

                $.ajax({
                    url: endPointUrl,
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        console.log('result',result);
                        
                        if (result.errors) {
                        
                            $('#div-rating-modal-error').html('');
                           $('#div-rating-modal-error').show();
                            $.each(result.errors, function(key, value) {
                                $('#div-rating-modal-error').append('<li class="">' +
                                    value + '</li>');
                            });
                        } else {
                             $('#div-rating-modal-error').hide();
                            swal({
                                title: "Saved",
                                text: "Rating saved successfully.",
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
                    },
                    error: function(data) {
                         $('#div-rating-modal-error').hide();
                        console.log(data);
                    }
                });
            });
        });
       
       
    </script>
    @endpush

@endonce
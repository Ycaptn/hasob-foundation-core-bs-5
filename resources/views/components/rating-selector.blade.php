@if (isset($ratable) && $ratable!=null)

        <a  href="#" 
            title="Rating 1" 
            id="btn-{{$control_id}}-1"
            class="btn-rating-select btn-outline"
            data-toggle="tooltip" 
            data-val-score="1"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{get_class($ratable)}}">
            <i class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 2" 
            id="btn-{{$control_id}}-2"
            class="btn-rating-select"
            data-toggle="tooltip" 
            data-val-score="2"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{get_class($ratable)}}">
            <i class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 3" 
            id="btn-{{$control_id}}-3"
            class="btn-rating-select"
            data-toggle="tooltip" 
            data-val-score="3"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{get_class($ratable)}}">
            <i class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 4" 
            id="btn-{{$control_id}}-4"
            class="btn-rating-select"
            data-toggle="tooltip" 
            data-val-score="4"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{get_class($ratable)}}">
            <i class="bx bx-star font-20 email-star"></i>
        </a>
        <a  href="#" 
            title="Rating 5" 
            id="btn-{{$control_id}}-5"
            class="btn-rating-select"
            data-toggle="tooltip" 
            data-val-score="5"
            data-val-id="{{$ratable->id}}"
            data-val-type="{{get_class($ratable)}}">
            <i class="bx bx-star font-20 email-star"></i>
        </a>

@endif




@once

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            //Save details
            $('.btn-rating-select').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                //implement
                //get ratable id
                //get ratable type
                //get rating score
                //call endpoint to update rating

                $.ajax({
                    url: endPointUrl,
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            //implement
                        } else {
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
                        console.log(data);
                    }
                });
            });
        });
    </script>
    @endpush

@endonce
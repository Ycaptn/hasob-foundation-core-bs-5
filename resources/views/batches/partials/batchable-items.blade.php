<div>

    <div class="row">

        @if (count($batchable_items) > 0)
            {{--        @if ($batch->status != 'processed') --}}
            <div class="row mb-3">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    @php
                        $filter_value = request()->input('filter');
                    @endphp

                    <select name="batch_filter" id="batch_filter" class="form-select">
                        <option value="">
                            --- select filter ---
                        </option>
                        @foreach ($batch_filter_items as $idx => $item)
                            <option value="{{ $item['key'] }}"
                                {{ strtolower($filter_value) == strtolower($item['key']) ? 'selected' : '' }}>
                                {{ $item['value'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-sm-6 ">
                <strong> Items that can be Batched </strong>
            </div>
            <div class="col-sm-6 mb-4">
                <button class="btn btn-primary btn-sm float-end btn-save-add-batch-item mx-2">Add Selected Items to
                    Batch</button>
            </div>
            {{--   @endif --}}
            <div id="div-batch-item-modal-error" class="alert alert-danger" role="alert"></div>
            @foreach ($batchable_items as $batchable_item)
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $batchable_item['value'] }}"
                            name="cbx_batchable_items" id="{{ $batchable_item['value'] }}-cbx_batchable_items">
                        <label class="form-check-label" for="{$batchable_item['value']}}-cbx_batchable_items">
                            {{ $batchable_item['key'] }}
                        </label>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-sm-6">
                <strong> Items that can be Batched </strong>
            </div>
            <div class="col-sm-6 mb-4">
            </div>
            <span class="my-3">No available item that can be batched</span>
        @endif


    </div>
</div>
@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div-batch-item-modal-error').hide();
            $('#batch_filter').change(function(e) {
                e.preventDefault();
                let filter = $(this).val();

                location.assign("{{ Request::url() }}?filter=" + filter)
            })
            $('.btn-save-add-batch-item').click(function(e) {
                e.preventDefault();
                //check for internet status 
                if (!window.navigator.onLine) {
                    $('.offline').fadeIn(300);
                    return;
                } else {
                    $('.offline').fadeOut(300);
                }
                $('.btn-save-add-batch-item span').show()
                $('.btn-save-remove-batch-item').attr('disabled', true)

                let selected_ids = [];
                $("input[name='cbx_batchable_items']:checked").each(function(item) {
                    selected_ids.push($(this).val());
                });

                if (selected_ids.length === 0) {

                    swal({
                        title: "Warning",
                        text: "No Batch Item Selected",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    }, function() {

                    });

                } else {


                    swal({
                        title: "Are you sure you want to add the select items to this this batch?",
                        text: "The selected batch items is modifiable when saved",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            swal({
                                title: '<div id="spinner-add-bacthable-items" class="spinner-border text-primary" role="status"> <span class="visually-hidden">  Loading...  </span> </div> <br><br>Adding to Batch...',
                                text: 'Please wait while selected is been added to batch.<br><br> Do not refresh this page! ',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                html: true
                            });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                }
                            });

                            let actionType = "POST";
                            let endPointUrl = "{{ route('fc-api.batch_items.store') }}";
                            let formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('batch_id', "{{ $batch->id }}");
                            formData.append('batchable_type', String
                                .raw`{{ $batch->batchable_type }}`);
                            formData.append('batchable_id', selected_ids);
                            formData.append('_method', actionType);

                            formData.append("batchable_id", selected_ids);
                            @if (isset($organization) && $organization != null)
                                formData.append('organization_id', '{{ $organization->id }}');
                            @endif

                            $.ajax({
                                url: endPointUrl,
                                type: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function(result) {
                                    if (result.errors) {
                                        $('#div-batch-item-modal-error').html('');
                                        $('#div-batch-item-modal-error').show();

                                        $.each(result.errors, function(key, value) {
                                            $('#div-batch-item-modal-error')
                                                .append(
                                                    '<li class="">' +
                                                    value + '</li>');
                                        });
                                    } else {
                                        $('#div-batch-item-modal-error').hide();
                                        window.setTimeout(function() {

                                            $('#div-batch-item-modal-error')
                                                .hide();

                                            swal({
                                                title: "Saved",
                                                text: "Batch items added successfully",
                                                type: "success",
                                                showCancelButton: false,
                                                closeOnConfirm: false,
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "OK",
                                                closeOnConfirm: false
                                            }, function() {
                                                location.reload(true);
                                            });

                                        }, 20);
                                    }
                                    $('.btn-save-add-batch-item').attr('disabled',
                                        false)
                                    $('.btn-save-add-batch-item span').hide()
                                },
                                error: function(data) {
                                    console.log(data);
                                    $('.btn-save-add-batch-item span').hide()
                                    $('.btn-save-add-batch-item').attr('disabled',
                                        false)
                                }
                            });
                        }
                    });

                }


            });
        });
    </script>
@endpush

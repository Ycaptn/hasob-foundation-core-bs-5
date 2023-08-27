@if ($artifactable!=null)

    @php
        //Get artifact value
        $artifact_id = '0';
        $artifact_value = $artifact_value_default;
        $artifact_value_object = $artifactable->artifact($artifact_key);
        if ($artifact_value_object!=null && empty($artifact_value_object->value)==false){
            $artifact_id = $artifact_value_object->id;
            $artifact_value = $artifact_value_object->value;
        }
    @endphp

    <a id="{{$control_id}}_btn_artifact" href="#" 
        data-val-artifact-id="{{$artifact_id}}"
        data-val-artifactable-id="{{$artifactable->id}}"
        data-val-artifactable-name="{{$artifact_label}}"
        data-val-artifactable-class="{{get_class($artifactable)}}"
        class="ms-auto {{$button_class}}">
        <i class="fa fa-list fa-fw"></i> {{$button_label}}
    </a> - {{$artifact_value}}

    <div class="modal fade" id="{{$control_id}}_artifacter-modal" tabindex="-1" role="dialog" aria-labelledby="artifacter-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="artifacter-modal-label">Edit {{$artifact_label}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="{{$control_id}}_error_div_artifacter" class="alert alert-danger" role="alert">
                        <span id="{{$control_id}}_error_msg_artifacter"></span>
                    </div>

                    <form class="form-horizontal" id="{{$control_id}}_upload-form" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input id="{{$control_id}}_artifacter_primary_id" type="hidden" value="0"/>
                        <input id="{{$control_id}}_artifacter_artifactable_id" type="hidden" value=""/>
                        <input id="{{$control_id}}_artifacter_artifactable_class" type="hidden" value=""/>
                        <input id="{{$control_id}}_artifacter_artifactable_name" type="hidden" value=""/>

                        <div class="mb-3">
                            <input type="text" id="{{$control_id}}_value_text" class="form-control" value="{{ $artifact_value=='All' ? '' : $artifact_value }}" />
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="{{$control_id}}_btn-add-artifacter" value="add">
                        <span id="{{$control_id}}_spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#{{$control_id}}_btn-add-artifacter span').hide();

            $('#{{$control_id}}_btn_artifact').click(function(e){
                $('#{{$control_id}}_error_div_artifacter').hide();
                $('#{{$control_id}}_upload-form').trigger("reset");
                $('#{{$control_id}}_artifacter-modal').modal('show');

                $('#{{$control_id}}_artifacter_primary_id').val($(this).attr('data-val-artifact-id'));
                $('#{{$control_id}}_artifacter_artifactable_id').val($(this).attr('data-val-artifactable-id'));
                $('#{{$control_id}}_artifacter_artifactable_name').val($(this).attr('data-val-artifactable-name'));
                $('#{{$control_id}}_artifacter_artifactable_class').val($(this).attr('data-val-artifactable-class'));
            });

            $("#{{$control_id}}_btn-add-artifacter").click(function(e){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                $('#{{$control_id}}_btn-add-artifacter span').show();
                $('#{{$control_id}}_btn-add-artifacter').attr('disabled',true);

                var formData = new FormData();
                var actionType = "POST";
                var endPointURL = "{{ route('fc-api.attributes.store') }}";

                formData.append('_token', $('input[name="_token"]').val());
                @if (isset($organization) && $organization!=null)
                    formData.append('organization_id', '{{$organization->id}}');
                @endif
                formData.append('artifactable_type', String.raw`{{get_class($artifactable)}}`);
                formData.append('artifactable_id', "{{$artifactable->id}}");
                formData.append('key', "{{$artifact_key}}");
                formData.append('value', $('#{{$control_id}}_value_text').val());

                var artifacter_primary_id = $('#{{$control_id}}_artifacter_primary_id').val();
                if (artifacter_primary_id != "0"){
                    actionType = "PUT";
                    formData.append('id', artifacter_primary_id);
                    endPointURL = "{{ route('fc-api.attributes.update','') }}/"+artifacter_primary_id;
                }
                
                formData.append('_method', actionType);

                $.ajax({
                    url: endPointURL,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        if(data.success == false){
                            $('#{{$control_id}}_error_div_artifacter').show();
                            $.each(result.errors, function(key, value){
                                $('#{{$control_id}}_error_msg_artifacter').append('<li class="">'+value+'</li>');
                            });

                            $('#{{$control_id}}_btn-add-artifacter span').hide();
                            $('#{{$control_id}}_btn-add-artifacter').attr('disabled',false);
                            
                        }else{
                             swal({
                                title: "Saved",
                                text: "{{$artifact_label}} Saved",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });
                            window.setTimeout(function(){location.reload(true);}, 1000);
                        }
                    },
                    error: function(data){
                        $('#{{$control_id}}_btn-add-artifacter span').hide();
                        $('#{{$control_id}}_btn-add-artifacter').attr('disabled',false);
                        console.log(data);
                    }
                });

            });

        });
    </script>
    @endpush

@endif
@if (isset($department_user) && $department_user!=null)
    <a  href="#" 
        title="Department Selection" 
        id="btn-{{$control_id}}"
        class="btn-department-selector me-1"
        data-toggle="tooltip" 
        data-val-id="{{$department_user->id}}">
            <i class="fa fa-unlink text-success small"></i>
    </a>
@endif



@once

    <div class="modal fade" id="mdl-department-selector-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 id="lbl-department-selector-modal-title" class="modal-title">Department Selection</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-department-selector-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-department-selector-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12">
                                @csrf

                                <div id="spinner-department-selector" class="">
                                    <div class="loader" id="loader-department-selector"></div>
                                </div>

                                <input id="department-selector-user-id" type="hidden" value="0" />

                                <div class="mb-3">
                                    <label class="form-label">Department</label>

                                      <div class="input-group">
                
                                        <select name="pm_department" class="form-select">
                                            <option value="">Select Department</option>
                                            @if (isset($available_departments) && $available_departments != null)
                                                @foreach ($available_departments as $idx=>$dept)
                                                <option value="{{$dept->id}}">{{$dept->long_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                      </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-department-selector-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $(document).on('click', ".btn-department-selector", function(e){
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('input[name="_token"]').val()}});

                let itemId = $(this).attr('data-val-id');
                $('#department-selector-user-id').val(itemId);

                $('#mdl-department-selector-modal').modal('show');
                $('#frm-department-selector-modal').trigger("reset");
            });

            //Save details
            $('#btn-save-mdl-department-selector-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                //implement
                //get user id
                //get new department
                //call endpoint to update user password

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
                                text: "Department updated successfully.",
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
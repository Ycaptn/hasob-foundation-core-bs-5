



    <div class="card ledger-list">
        <div class="card-body">

            @if (isset($ledgers) && count($ledgers)>0)
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="50%">Ledger Name</th>
                                    <th class="text-center w-25">Balance</th>
                                    <th class="text-center w-25">Entries</th>
                                    <th>Creator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ledgers as $item)
                                <tr>
                                    <td width="50%">
                                        
                                        <a href="javascript:void(0)" class="pr-10 text-primary btn-edit-mdl-ledger-modal" data-bs-toggle="tooltip" data-val="{{$item->id}}" title="" data-original-title="Edit" aria-describedby="tooltip563536">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                
                                        {{$item->name}}
                                    </td>
                                    <td class="text-center">
                                        {{number_format($item->balance(),2)}}
                                    </td>
                                    <td class="text-center">
                                        {{$item->item_count()}}
                                    </td>
                                    <td>
                                        @if ($item->creator_user != null)
                                        {{$item->creator_user->full_name}}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p>No Ledgers, use the create button to create a ledger.</p>
            @endif
            
        </div>
    </div>


    <div class="modal fade" id="mdl-ledger-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="lbl-ledger-modal-title">Ledger</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body">
                    <div id="div-ledger-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-ledger-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        @csrf
    
                        <input type="hidden" id="txt-ledger-primary-id" value="0" />

                        <div id="div-edit-txt-ledger-primary-id">
                            <div>
                                @include('hasob-foundation-core::ledgers.fields')
                            </div>
                        </div>
                    </form>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-ledger-modal" value="add">
                    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="visually-hidden">Loading...</span>Save</button>
                </div>
    
            </div>
        </div>
    </div>



@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
        //Show Modal for New Entry
        $(document).on('click', ".btn-new-mdl-ledger-modal", function(e) {
            $('#div-ledger-modal-error').hide();
            $('#mdl-ledger-modal').modal('show');
            $('#frm-ledger-modal').trigger("reset");
            $('#txt-ledger-primary-id').val(0);
    
            $('#div-show-txt-ledger-primary-id').hide();
            $('#div-edit-txt-ledger-primary-id').show();
            $('#spinner').hide();
        });
    
        //Show Modal for View
        $(document).on('click', ".btn-show-mdl-ledger-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            $('#div-show-txt-ledger-primary-id').show();
            $('#div-edit-txt-ledger-primary-id').hide();

            $('#spinner').show();
                $('#btn-show-mdl-ledger-modal').prop("disabled", true);
            let itemId = $(this).attr('data-val');
    
            // $.get( "{{URL::to('/')}}/api/fc_ledgers/"+itemId).done(function( data ) {
            $.get( "{{URL::to('/')}}/api/fc_ledgers/"+itemId).done(function( response ) {
                $('#div-ledger-modal-error').hide();
                $('#mdl-ledger-modal').modal('show');
                $('#frm-ledger-modal').trigger("reset");
                $('#txt-ledger-primary-id').val(response.data.id);
    
                // $('#spn_ledger_').html(response.data.);
                // $('#spn_ledger_').html(response.data.);   
            });
        });
    
        //Show Modal for Edit
        $(document).on('click', ".btn-edit-mdl-ledger-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
             //console.log(itemId);
            $('#div-show-txt-ledger-primary-id').hide();
            $('#div-edit-txt-ledger-primary-id').show();

            $('#spinner').hide();
                $('#btn-show-mdl-ledger-modal').prop("disabled", false);     
           
            let itemId = $(this).attr('data-val');
            $.get( "{{route('fc.ledgers.show','')}}/"+itemId).done(function(data) {
                //console.log(itemId);
                $('#div-ledger-modal-error').hide();
                $('#mdl-ledger-modal').modal('show');
                $('#frm-ledger-modal').trigger("reset");
                $('#txt-ledger-primary-id').val(data.response.id);
                $('#ledger_name').val(data.response.name);
    
                // $('#').val(response.data.);
                // $('#').val(response.data.);
            });
        });
    
        //Delete action
        $(document).on('click', ".btn-delete-mdl-ledger-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            let itemId = $(this).attr('data-val');
             swal({
                title: "Are you sure you want to delete this Ledger?",
                text: "You will not be able to recover this Ledger record if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
           
    
                let endPointUrl = "{{ route('fc.ledgers.destroy',0) }}"+itemId;
    
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
                        }else{
                            
                             swal({
                                        title: "Deleted",
                                        text: "The Ledger record has been deleted.",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    })
                                    setTimeout(function(){
                                        location.reload(true);
                                }, 1000);
                        }
                    },
                });            
            }
        });
    });
    
        //Save details
        $('#btn-save-mdl-ledger-modal').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
            $('#spinner').show();
                $('#btn-save-mdl-ledger-modal').prop("disabled", true);
            let primaryId = $('#txt-ledger-primary-id').val();
            let actionType = "POST";
            let endPointUrl = "{{ route('fc.ledgers.store') }}"
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            if(primaryId != "0") {
                actionType = "PUT";
                endPointUrl = "{{ route('fc.ledgers.update','') }}/"+primaryId;
                formData.append('id', primaryId);
            }
            formData.append('_method', actionType);
            formData.append('id', primaryId);
            formData.append('name', $('#ledger_name').val());
            formData.append('department_id', $('#ledger_department').val());
            formData.append('organization_id', $('#organization_id').val());
    
            $.ajax({
                url: endPointUrl,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        $('#div-ledger-modal-error').html('');
                        $('#div-ledger-modal-error').show();
                        
                        $.each(result.errors, function(key, value){
                            $('#spinner').hide();
                            $('#btn-save-mdl-ledger-modal').prop("disabled", false);
                            $('#div-ledger-modal-error').append('<li class="">'+value+'</li>');
                        });
                    }else{
                        $('#div-ledger-modal-error').hide();
                        $('#spinner').hide();
                            $('#btn-save-mdl-ledger-modal').prop("disabled", false);
                            $('#div-ledger-modal-error').hide();
                       
                         swal({
                                title: "Saved",
                                text: "The Ledger record saved successfully.",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })

                            setTimeout(function(){
                                location.reload(true);
                        }, 1000)
                    }
                }, error: function(data){
                    $('#spinner').hide();
                    $('#btn-save-mdl-ledger-modal').prop("disabled", false);
                    console.log(data);
                }
            });
        });
    
    });
    </script>
@endpush
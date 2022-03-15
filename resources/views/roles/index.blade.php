@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
System Roles
@stop

@section('page_title')
System Roles
@stop

@section('app_css')
    @include('layouts.datatables_css')
@endsection

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade in" id="mdlRoleDetails" tabindex="-1" role="dialog" aria-labelledby="lblRoleDetails">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="lblRoleDetails">Role Details</h4>
                </div>
                <div class="modal-body">
                    <div id="errorDivRoleDetails" class="alert alert-danger" role="alert">
                        <span id="errorMsgRoleDetails"></span>
                    </div>
        
                    @include('hasob-foundation-core::roles.partials.role-detail')
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSaveRoleDetails" data-val="0">Save Changes</button>
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>

@stop


@push('page_scripts')

    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        $(document).ready(function() {

            $('.buttons-csv').hide();
            $('.buttons-pdf').hide();
            $('.buttons-print').hide();
            $('.buttons-excel').hide();

            $('#errorDivRoleDetails').hide();

            $('#btnNewRole').click(function(e){
                $('#errorDivRoleDetails').hide();
                $('#idRoleDetails').val(-1);
                $('#mdlRoleDetails').modal('show');
            });

            $(document).on('click', ".btnEditRole", function(e) {
                $('#errorDivRoleDetails').hide();
                $('#idRoleDetails').val($(this).attr('data-val'));

                $.get("{{ route('fc.role.show',0) }}"+$(this).attr('data-val')).done(function( data ) {
                    $('#nameRoleDetails').val(data.name);
                    $('#mdlRoleDetails').modal('show');
                });
            });

            $("#btnSaveRoleDetails").click(function(e){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                $.ajax({
                    url: "{{ route('fc.role.store',0) }}"+$('#idRoleDetails').val(),
                    type: 'POST',
                    data: {
                        'roleId':$('#idRoleDetails').val(),
                        'roleName':$('input[name="nameRoleDetails"]').val(),
                    },
                    success: function(data){
                        if (data!=null && data.status=='fail'){
                            $('#errorDivRoleDetails').show();
                            if (data.response!=null){
                                if ($.isArray(data.response)){
                                    for (x in data.response) {
                                        if ($.isArray(data.response[x])){
                                            $('#errorMsgRoleDetails').html('<strong>Errors</strong><br/>'+data.response[x].join('<br/>'));
                                        }else{
                                            $('#errorMsgRoleDetails').html('<strong>Errors</strong><br/>'+data.response[x]);
                                        }
                                    }
                                } else if (typeof data.response == "string" || typeof data.response == "integer") {
                                    $('#errorMsgRoleDetails').html('<strong>Errors</strong><br/>'+data.response);
                                } else {
                                    $('#errorMsgRoleDetails').html('<strong>Errors</strong><br/>'+JSON.stringify(data.response).replace(/[\[\]']+/g,' ').replace(/[\{\}']+/g,' ').replace(/[\"\"]+/g,'') );
                                }
                            } else {
                                $('#errorMsgRoleDetails').html('<strong>Error</strong><br/>An error has occurred.');
                            }
                        }else if (data!=null && data.status=='ok'){
                            alert('Saved Successfully');
                            location.reload();
                        }else{
                            $('#errorMsgRoleDetails').html('<strong>Error</strong><br/>An error has occurred.');
                        }
                    },
                    error: function(data){ console.log('Error:', data); }
                });
            });

        });
    </script>

@endpush
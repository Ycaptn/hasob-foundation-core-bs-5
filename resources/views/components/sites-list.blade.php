

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
    
    @foreach ($sites as $item)
    <div class="col">
        <div class="card site-item">
            <div class="row g-0">
                <div class="col-lg-2">
                    <center>
                        <a href="{{ route('fc.sites.show',$item->id) }}">
                            <i class="fa fa-3x fa-paper-plane-o mt-4 ml-3"></i>
                        </a>
                    </center>
                </div>
                <div class="col-lg-10">
                    <div class="card-body">
                            
        
                        <div class="d-flex align-items-center">
                            <div><h4 class="card-title"><a href="{{ route('fc.sites.show',$item->id) }}">{{ $item->site_name }}</a></h4></div>
                            <div class="ms-auto"> 
                                <a data-toggle="tooltip" 
                                    title="Pages" 
                                    data-val="{{$item->id}}" 
                                    data-toggle="tooltip" 
                                    data-original-title="Pages"
                                    class="btn-edit-mdl-site-modal inline-block mr-5" href="#">
                                    <i class="fa fa-files-o txt-primary" style="opacity:80%"></i>
                                </a>

                                @if (\Auth::user()!=null && \Auth::user()->hasAnyRole('admin','department-admin'))
                                <a data-toggle="tooltip" 
                                    title="Edit" 
                                    data-val="{{$item->id}}" 
                                    data-toggle="tooltip" 
                                    data-original-title="Edit"
                                    class="btn-edit-mdl-site-modal inline-block mr-5" href="#">
                                    <i class="bx bxs-edit txt-warning" style="opacity:80%"></i>
                                </a>
                                <a data-toggle="tooltip" 
                                    title="Delete" 
                                    data-val="{{$item->id}}" 
                                    data-toggle="tooltip" 
                                    data-original-title="Delete"
                                    class="btn-delete-mdl-site-modal inline-block mr-5" href="#">
                                    <i class="bx bxs-trash-alt txt-danger" style="opacity:80%"></i>
                                </a>
                                @endif
                            </div>
                            
                        </div>
        
                        <div class="clearfix">
                            <p class="mb-0 fst-italic"> 
                                @if (empty($item->description) == false)
                                    {!! \Illuminate\Support\Str::limit($item->description,40,' ...') !!}
                                @else
                                    No Description
                                @endif
                            </p>
                            <p class="mb-0">
                                <span>
                                    @php
                                        $site_id = empty($item->site_path) ? $item->id : $item->site_path;
                                    @endphp
                                    <a href="{{ route('fc.site-display.index',$site_id) }}">
                                        {!! \Illuminate\Support\Str::limit(route('fc.site-display.index',$site_id),40,' ...') !!}
                                    </a>
                                </span>
                            </p>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

        
    <div class="modal fade" id="mdl-site-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 id="lbl-site-modal-title" class="modal-title">Site</h4>
                </div>

                <div class="modal-body">
                    <div id="div-site-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-site-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">
                                @csrf
                                
                                <div id="spinner1" class="">
                                    <div class="loader" id="loader-1"></div>
                                </div>

                                <input type="hidden" id="txt-site-primary-id" value="0" />
                                <div id="div-show-txt-site-primary-id">
                                    <div class="row">
                                        <div class="col-lg-10 ma-10">
                                        </div>
                                    </div>
                                </div>
                                <div id="div-edit-txt-site-primary-id">
                                    <div class="row">
                                        <div class="col-lg-10 ma-10">
                                        @include('hasob-foundation-core::sites.fields')
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-site-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>

</div>


@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
        //Show Modal for New Entry
        $(document).on('click', ".btn-new-mdl-site-modal", function(e) {
            $('#div-site-modal-error').hide();
            $('#mdl-site-modal').modal('show');
            $('#frm-site-modal').trigger("reset");
            $('#txt-site-primary-id').val(0);
    
            $('#div-show-txt-site-primary-id').hide();
            $('#div-edit-txt-site-primary-id').show();
        });
    
        //Show Modal for View
        $(document).on('click', ".btn-show-mdl-site-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            $('#div-show-txt-site-primary-id').show();
            $('#div-edit-txt-site-primary-id').hide();
            let itemId = $(this).attr('data-val');
    
            // $.get( "{{URL::to('/')}}/api/fc_sites/"+itemId).done(function( data ) {
            $.get( "{{URL::to('/')}}/api/fc_sites/"+itemId).done(function( response ) {
                $('#div-site-modal-error').hide();
                $('#mdl-site-modal').modal('show');
                $('#frm-site-modal').trigger("reset");
                $('#txt-site-primary-id').val(response.data.id);
    
                // $('#spn_site_').html(response.data.);
                // $('#spn_site_').html(response.data.);   
            });
        });
    
        //Show Modal for Edit
        $(document).on('click', ".btn-edit-mdl-site-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            $('#div-show-txt-site-primary-id').hide();
            $('#div-edit-txt-site-primary-id').show();
            let itemId = $(this).attr('data-val');
    
            // $.get( "{{URL::to('/')}}/api/fc_sites/"+itemId).done(function( data ) {
            $.get( "{{URL::to('/')}}/api/fc_sites/"+itemId).done(function( response ) {            
                $('#div-site-modal-error').hide();
                $('#mdl-site-modal').modal('show');
                $('#frm-site-modal').trigger("reset");
                $('#txt-site-primary-id').val(response.data.id);
    
                // $('#').val(response.data.);
                // $('#').val(response.data.);
            });
        });
    
        //Delete action
        $(document).on('click', ".btn-delete-mdl-site-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            let itemId = $(this).attr('data-val');
            if (confirm("Are you sure you want to delete this Site?")){
    
                let endPointUrl = "{{ route('fc.sites.destroy',0) }}"+itemId;
    
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
                            window.alert("The Site record has been deleted.");
                            location.reload(true);
                        }
                    },
                });            
            }
        });
    
        //Save details
        $('#btn-save-mdl-site-modal').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
    
            let actionType = "POST";
            let endPointUrl = "{{ route('fc.sites.store') }}";
            let primaryId = $('#txt-site-primary-id').val();
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
    
            if (primaryId != "0"){
                actionType = "PUT";
                endPointUrl = "{{ route('fc.sites.update','') }}/"+primaryId;
                formData.append('id', primaryId);
            }
            
            formData.append('_method', actionType);
            formData.append('site_name', $('#site_name').val());
            formData.append('description', $('#site_description').val());
    
            $.ajax({
                url:endPointUrl,
                type: actionType,
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        $('#div-site-modal-error').html('');
                        $('#div-site-modal-error').show();
                        
                        $.each(result.errors, function(key, value){
                            $('#div-site-modal-error').append('<li class="">'+value+'</li>');
                        });
                    }else{
                        $('#div-site-modal-error').hide();
                        window.setTimeout( function(){
                            window.alert("The Site record saved successfully.");
                            $('#div-site-modal-error').hide();
                            location.reload(true);
                        },20);
                    }
                }, error: function(data){
                    console.log(data);
                }
            });
        });
    
    });
</script>
@endpush
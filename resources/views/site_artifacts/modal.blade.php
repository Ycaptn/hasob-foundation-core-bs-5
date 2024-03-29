

<div class="modal fade" id="mdl-siteArtifact-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 id="lbl-siteArtifact-modal-title" class="modal-title">Site Artifact</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-siteArtifact-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-siteArtifact-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline">You are currently offline</span></div>
                            <div id="spinner-site_artifacts" class="">
                                <div class="loader" id="loader-1"></div>
                            </div>

                            <input type="hidden" id="txt-siteArtifact-primary-id" value="0" />
                            <div id="div-show-txt-siteArtifact-primary-id">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">                            
                                    @include('hasob-foundation-core::site_artifacts.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-siteArtifact-primary-id">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">
                                    @include('hasob-foundation-core::site_artifacts.fields')
                                    </div>
                                </div>
                            </div>

                            <div id="div-edit-txt-siteArtifact-page-selector">
                                <div class="row">
                                    <div class="col-lg-12 ma-10">
                                        @if (isset($site) && $site != null && count($site->pages()) > 0)
                                        <select id="site-artifact-related-page-id" class="form-select">
                                            <option value="">None</option>
                                            @foreach ($site->pages() as $page)
                                            <option value="{{$page->id}}">{{$page->page_name}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div id="div-save-mdl-siteArtifact-modal" class="modal-footer">
                <hr class="light-grey-hr" />
                <button type="button" class="btn btn-primary" id="btn-save-mdl-siteArtifact-modal" value="add">
                    <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="visually-hidden">Loading...</span>
                    Save
                </button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#btn-save-mdl-siteArtifact-modal span').hide();
        $('.offline').hide();

        //Show Modal for New Entry
        $(document).on('click', ".btn-new-mdl-siteArtifact-modal", function(e) {
            // $('#div-siteArtifact-modal-error').hide();
            // $('#mdl-siteArtifact-modal').modal('show');
            // $('#frm-siteArtifact-modal').trigger("reset");
            // $('#txt-siteArtifact-primary-id').val(0);

            // $('#div-show-txt-siteArtifact-primary-id').hide();
            // $('#div-edit-txt-siteArtifact-primary-id').show();
            
            // $("#spinner-site_artifacts").hide();
            // $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
        });

        //Show Modal for View
        $(document).on('click', ".btn-show-mdl-siteArtifact-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            //check for internet status 
            if (!window.navigator.onLine) {
                $('.offline').fadeIn(300);
                return;
            }else{
                $('.offline').fadeOut(300);
            }

            $('#div-siteArtifact-modal-error').hide();
            $('#mdl-siteArtifact-modal').modal('show');
            $('#frm-siteArtifact-modal').trigger("reset");

            $("#spinner-site_artifacts").show();
            $("#div-save-mdl-siteArtifact-modal").attr('disabled', true);

            $('#div-show-txt-siteArtifact-primary-id').show();
            $('#div-edit-txt-siteArtifact-primary-id').hide();
            let itemId = $(this).attr('data-val');

            $.get( "{{ route('fc-api.siteArtifacts.show','') }}/"+itemId).done(function( response ) {
                $('#txt-siteArtifact-primary-id').val(response.data.id);
                $('#spn_siteArtifact_headline').html(response.data.headline);
                $('#spn_siteArtifact_type').html(response.data.type);
                $('#spn_siteArtifact_content').html(response.data.content);

                $('#spn_siteArtifact_display_start_date').html(response.data.display_start_date);
                $('#spn_siteArtifact_display_end_date').html(response.data.display_end_date);
                $('#spn_siteArtifact_specific_display_date').html(response.data.specific_display_date);

                $("#spinner-site_artifacts").hide();
                $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
            });
        });

        //Show Modal for Edit
        $(document).on('click', ".btn-edit-mdl-siteArtifact-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            $('#div-siteArtifact-modal-error').hide();
            $('#mdl-siteArtifact-modal').modal('show');
            $('#frm-siteArtifact-modal').trigger("reset");

            $("#spinner-site_artifacts").show();
            $("#div-save-mdl-siteArtifact-modal").attr('disabled', true);

            $('#div-show-txt-siteArtifact-primary-id').hide();
            $('#div-edit-txt-siteArtifact-primary-id').show();
            let itemId = $(this).attr('data-val');

            $.get("{{ route('fc-api.siteArtifacts.show','') }}/"+itemId).done(function( response ) {     
            
                $('#txt-siteArtifact-primary-id').val(response.data.id);
                $('#headline').val(response.data.headline);
                $('#type').val(response.data.type);
                $('#content').val(response.data.content);

                if (response.data.display_start_date != null){
                    $('#display_start_date').val(response.data.display_start_date);
                }
                if (response.data.display_end_date != null){
                    $('#display_end_date').val(response.data.display_end_date);
                }
                if (response.data.specific_display_date != null){
                    $('#specific_display_date').val(response.data.specific_display_date);
                }

                $('#site-artifact-related-page-id').val(null);
                if (response.data.page_id != null){
                    $('#site-artifact-related-page-id').val(response.data.page_id);
                }

                $("#spinner-site_artifacts").hide();
                $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
            });
        });

        //Delete action
        $(document).on('click', ".btn-delete-mdl-siteArtifact-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            //check for internet status 
            if (!window.navigator.onLine) {
                $('.offline').fadeIn(300);
                return;
            }else{
                $('.offline').fadeOut(300);
            }

            let itemId = $(this).attr('data-val');
            swal({
                    title: "Are you sure you want to delete this SiteArtifact record?",
                    text: "You will not be able to recover this SiteArtifact record if deleted.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {

                        let endPointUrl = "{{ route('fc-api.siteArtifacts.destroy','') }}/"+itemId;

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
                                    swal("Error", "Oops an error occurred. Please try again.", "error");
                                }else{
                                    //swal("Deleted", "SiteArtifact deleted successfully.", "success");
                                    swal({
                                            title: "Deleted",
                                            text: "SiteArtifact deleted successfully",
                                            type: "success",
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false
                                        });
                                        window.setTimeout(function(){
                                        location.reload(true);
                                        }, 1000);
                                }
                            },
                        });
                    }
                });

        });

        //Save details
        $('#btn-save-mdl-siteArtifact-modal').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            //check for internet status 
            if (!window.navigator.onLine) {
                $('.offline').fadeIn(300);
                return;
            }else{
                $('.offline').fadeOut(300);
            }

            $('#btn-save-mdl-siteArtifact-modal span').show();
            $('#btn-save-mdl-siteArtifact-modal').attr('disabled',true);

            let actionType = "POST";
            let endPointUrl = "{{ route('fc-api.siteArtifacts.store') }}";
            let primaryId = $('#txt-siteArtifact-primary-id').val();
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());

            if (primaryId != "0"){
                actionType = "PUT";
                endPointUrl = "{{ route('fc-api.siteArtifacts.update','') }}/"+primaryId;
                formData.append('id', primaryId);
            }
            
            formData.append('_method', actionType);
            @if (isset($organization) && $organization!=null)
                formData.append('organization_id', '{{$organization->id}}');
            @endif
            @if (isset($site) && $site!=null)
                formData.append('site_id', "{{$site->id}}");
            @endif

            formData.append('headline', $('#headline').val());
            formData.append('content', $('#content').val());
            formData.append('creator_user_id', "{{Auth::id()}}");
            formData.append('type', $('#type').val());

            if ($('#display_start_date')!=null && $('#display_start_date').val()!=null){
                formData.append('display_start_date', $('#display_start_date').val());
            }
            if ($('#display_end_date')!=null && $('#display_end_date').val()!=null){
                formData.append('display_end_date', $('#display_end_date').val());
            }
            if ($('#specific_display_date')!=null && $('#specific_display_date').val()!=null){
                formData.append('specific_display_date', $('#specific_display_date').val());
            }

            if ($('#site-artifact-related-page-id')!=null && $('#site-artifact-related-page-id').val()!=null){
                formData.append('page_id', $('#site-artifact-related-page-id').val());
            }

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
                        $('#div-siteArtifact-modal-error').html('');
                        $('#div-siteArtifact-modal-error').show();
                        
                        $.each(result.errors, function(key, value){
                            $('#div-siteArtifact-modal-error').append('<li class="">'+value+'</li>');
                        });
                    }else{
                        $('#div-siteArtifact-modal-error').hide();
                        $('#btn-save-mdl-siteArtifact-modal span').hide();
                        $('#btn-save-mdl-siteArtifact-modal').attr('disabled',false);
                    
                        $('#btn-save-mdl-siteArtifact-modal span').hide();
                        $('#btn-save-mdl-siteArtifact-modal').attr('disabled',false);
                        $('#div-siteArtifact-modal-error').hide();
                        
                        swal({
                                title: "Saved",
                                text: "SiteArtifact saved successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            })
                            
                            setTimeout(function(){
                                location.reload(true);
                        }, 1000);
                    }

                    $('#btn-save-mdl-siteArtifact-modal span').hide();
                    $('#btn-save-mdl-siteArtifact-modal').attr('disabled',false);

                    $("#spinner-site_artifacts").hide();
                    $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
                    
                }, error: function(data){
                    console.log(data);
                    swal("Error", "Oops an error occurred. Please try again.", "error");
                    $('#btn-save-mdl-siteArtifact-modal span').hide();
                    $('#btn-save-mdl-siteArtifact-modal').attr('disabled',false);
                    $("#spinner-site_artifacts").hide();
                    $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
                }
            });
        });

    });
</script>
@endpush

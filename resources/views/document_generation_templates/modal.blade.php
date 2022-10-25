

<div class="modal fade" id="mdl-documentGenerationTemplate-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form class="form-horizontal" id="frm-documentGenerationTemplate-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                <div class="modal-header">

                    
                        <div class="col-lg-10">
                            {!! Form::text('title', null, ['placeholder'=>'Title','id'=>'title','class'=>'form-control','minlength' => 4,'maxlength' => 150]) !!}
                        </div>
                    

                    {{-- <h5 id="lbl-documentGenerationTemplate-modal-title" class="modal-title">Template</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-documentGenerationTemplate-modal-error" class="alert alert-danger" role="alert"></div>
                    <div class="row">
                        <div class="col-lg-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-document_generation_templates">You are currently offline</span></div>

                            <div id="spinner-document_generation_templates" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-documentGenerationTemplate-primary-id" value="0" />

                            <div id="div-content" class="form-group">
                                <div class="col-lg-12">
                                    <textarea id="content" name="content" class="summernote"></textarea>
                                    {{-- <textarea id="content" name="content" class="form-control" rows="23"></textarea> --}}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-2">

                            <label class="col-lg-12 small col-form-label fw-bold">Ouput Formats</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="text/plain" name="cbx-output-format" id="cbx-plain">
                                <label class="form-check-label" for="cbx-plain">Plain Text</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="application/msword" name="cbx-output-format" id="cbx-ms-word">
                                <label class="form-check-label" for="cbx-ms-word">MS Word</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="application/pdf" name="cbx-output-format" id="cbx-pdf">
                                <label class="form-check-label" for="cbx-pdf">PDF</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="text/html" name="cbx-output-format" id="cbx-html">
                                <label class="form-check-label" for="cbx-html">HTML</label>
                            </div>

                            <div id="div-file_name_prefix" class="form-group">
                                <label for="title" class="col-lg-12 small col-form-label fw-bold">File Name Prefix</label>
                                <div class="col-lg-11">
                                    {!! Form::text('file_name_prefix', null, ['id'=>'file_name_prefix', 'class' => 'form-control','minlength' => 0,'maxlength' => 2000]) !!}
                                </div>
                            </div>

                            <label class="col-lg-12 small col-form-label fw-bold">Applies to</label>
                            @foreach(\FoundationCore::get_document_generator_models($organization) as $idx=>$model)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $model->value }}" name="cbx-doc-models">
                                    <label class="form-check-label">{{ $model->key }}</label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </form>
        
            <div class="modal-footer" id="div-save-mdl-documentGenerationTemplate-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-documentGenerationTemplate-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_css')
<link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.css') }}">
@endpush

@push('page_scripts')
<script src="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {


    $('#content').summernote({
        height: 500,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            //['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']],
        ],
        'codemirror': {
            'mode': 'htmlmixed',
            'lineNumbers': 'true',
            'theme': 'monokai',
        },
    });   

    $('.offline-document_generation_templates').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-documentGenerationTemplate-modal", function(e) {
        $('#div-documentGenerationTemplate-modal-error').hide();
        $('#mdl-documentGenerationTemplate-modal').modal('show');
        $('#frm-documentGenerationTemplate-modal').trigger("reset");
        $('#txt-documentGenerationTemplate-primary-id').val(0);

        $('#div-show-txt-documentGenerationTemplate-primary-id').hide();
        $('#div-edit-txt-documentGenerationTemplate-primary-id').show();

        $("#spinner-document_generation_templates").hide();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-documentGenerationTemplate-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-document_generation_templates').fadeIn(300);
            return;
        }else{
            $('.offline-document_generation_templates').fadeOut(300);
        }

        $('#div-documentGenerationTemplate-modal-error').hide();
        $('#mdl-documentGenerationTemplate-modal').modal('show');
        $('#frm-documentGenerationTemplate-modal').trigger("reset");

        $("#spinner-document_generation_templates").show();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', true);

        $('#div-show-txt-documentGenerationTemplate-primary-id').show();
        $('#div-edit-txt-documentGenerationTemplate-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.document_generation_templates.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-documentGenerationTemplate-primary-id').val(response.data.id);
            $('#spn_documentGenerationTemplate_title').html(response.data.title);
		    $('#spn_documentGenerationTemplate_content').html(response.data.content);

            $("#spinner-document_generation_templates").hide();
            $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-documentGenerationTemplate-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-documentGenerationTemplate-modal-error').hide();
        $('#mdl-documentGenerationTemplate-modal').modal('show');
        $('#frm-documentGenerationTemplate-modal').trigger("reset");

        $("#spinner-document_generation_templates").show();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', true);

        $('#div-show-txt-documentGenerationTemplate-primary-id').hide();
        $('#div-edit-txt-documentGenerationTemplate-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('fc-api.document_generation_templates.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-documentGenerationTemplate-primary-id').val(response.data.id);
            $('#title').val(response.data.title);
            $("#content").summernote("code", response.data.content);
            $('#file_name_prefix').val(response.data.file_name_prefix);

            if (response.data.model_names.length > 0){
                $('input[name="cbx-doc-models"]').each(function(){ 
                    if (response.data.model_names.includes(this.value.split("\\").pop())){
                        $(this).prop('checked', 'checked');
                    }
                });
            }

            if (response.data.output_content_types.length > 0){
                $('input[name="cbx-output-format"]').each(function(){ 
                    if (response.data.output_content_types.includes(this.value)){
                        $(this).prop('checked', 'checked');
                    }
                });
            }

            $("#spinner-document_generation_templates").hide();
            $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-documentGenerationTemplate-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-document_generation_templates').fadeIn(300);
            return;
        }else{
            $('.offline-document_generation_templates').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Document Template?",
                text: "You will not be able to recover this Document Template if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('fc-api.document_generation_templates.destroy','') }}/"+itemId;

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
                                swal({
                                        title: "Deleted",
                                        text: "Document Template deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },function(){
                                        location.reload(true);
                                });
                            }
                        },
                    });
                }
            });

    });

    //Save details
    $('#btn-save-mdl-documentGenerationTemplate-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-document_generation_templates').fadeIn(300);
            return;
        }else{
            $('.offline-document_generation_templates').fadeOut(300);
        }

        $("#spinner-document_generation_templates").show();
        $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('fc-api.document_generation_templates.store') }}";
        let primaryId = $('#txt-documentGenerationTemplate-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('fc-api.document_generation_templates.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        if ($('#title').length){	formData.append('title',$('#title').val());	}
		//if ($('#content').length){	formData.append('content',$('#content').val());	}
        formData.append('content', $('#content').summernote('code'));

        if ($('#file_name_prefix').length){	formData.append('file_name_prefix',$('#file_name_prefix').val());	}
        if ($('input[name="cbx-doc-models"]:checked').length){	
            formData.append('doc_models',$('input[name="cbx-doc-models"]:checked').map(function(){ return this.value;}).get());	
        }
        if ($('input[name="cbx-output-format"]:checked').length){	
            formData.append('output_types',$('input[name="cbx-output-format"]:checked').map(function(){ return this.value;}).get());	
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
					$('#div-documentGenerationTemplate-modal-error').html('');
					$('#div-documentGenerationTemplate-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-documentGenerationTemplate-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-documentGenerationTemplate-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-documentGenerationTemplate-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "DocumentGenerationTemplate saved successfully",
                                type: "success"
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-document_generation_templates").hide();
                $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-document_generation_templates").hide();
                $("#div-save-mdl-documentGenerationTemplate-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush

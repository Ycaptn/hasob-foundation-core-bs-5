@extends('layouts.app')

@php
    $control_id = "pg-".time().rand(3333,4444);
    $default_page = null;
    $pages = $site->pages();    
    if (isset($page) && $page!=null){
        $default_page = $page;
    } else {
        foreach($pages as $site_page){
            if ($site_page->is_site_default_page){
                $page = $site_page;
                $default_page = $site_page;
            }
        }
    }
@endphp

@section('title_postfix')
    {{ $site->site_name }}
    @if(isset($page)) 
        - {{$page->page_name}}
    @endif
@stop

@section('page_title')
    @if(isset($page) && isset($site))
        {{ $site->site_name }}
    @else
        Site
    @endif
@stop

@section('page_title_suffix')
    @if(isset($page)) 
        <span id="spn_page_title">{{$page->page_name}}</span>
    @elseif(isset($site)) 
        {{ $site->site_name }} 
    @endif
@stop

@section('page_title_subtext')
    @if(isset($page) && isset($site))
        <a class="ms-10 mb-10" href="{{ route('fc.site-display', $site->id) }}" style="font-size:11px;color:blue;">
            <i class="fa fa-angle-double-left"></i> Back to {{ $site->site_name }}
        </a>
    @else
        <a class="ms-10 mb-10" href="{{ route('dashboard') }}" style="font-size:11px;color:blue;">
            <i class="fa fa-angle-double-left"></i> Back to Dashboard
        </a>
    @endif
@stop


@section('page_title_buttons')
    <span class="float-end">
        @if (isset($page) && $page!=null)
            <a id="btn-edit-page" href="#" @if(isset($page)) data-val='{{ $page->id }}' @endif class='btn btn-sm btn-warning' style="display:none;">
                <i class="fa fa-edit" aria-hidden="true"></i> Edit Page
            </a>
            <a id="btn-save-page" href="#" @if(isset($page)) data-val='{{ $page->id }}' @endif class='btn btn-sm btn-danger' style="display:none;">
                <i class="fa fa-save" aria-hidden="true"></i> Save Page
            </a>
            <a id="btn-cancel-page" href="#" @if(isset($page)) data-val='{{ $page->id }}' @endif class='btn btn-sm btn-info' style="display:none;">
                <i class="fa fa-times" aria-hidden="true"></i> Cancel
            </a>
            <a id="btn-new-page" href="#" data-val='{{ $site->id }}' class='btn btn-sm btn-danger' style="display:none;">
                <i class="fa fa-file" aria-hidden="true"></i> New Page
            </a>
        @endif
        @if (Auth()->user()->hasAnyRole(['site-admin','admin']) || Auth()->user()->id == $site->creator_user_id)
        <a id="btn-edit-site" href="{{route('fc.sites.show',$site->id)}}" data-val='{{ $site->id }}' class='btn btn-sm btn-primary btn-edit-mdl-site-modal' style="display:none;">
            <i class="icon wb-reply" aria-hidden="true"></i>Edit Site
        </a>
        @endif
    </span>
@stop

@push('page_css')
<link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.css') }}" />
<link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/simplemde-1.11.2-dist/simplemde.min.css') }}" />
<style type="text/css">
    .CodeMirror {
        height: 500px;
    }
    .editor-preview-active,
    .editor-preview-active-side {
        /*display:block;*/
    }
    .editor-preview-side>p,
    .editor-preview>p {
        margin:inherit;
    }
    .editor-preview pre,
    .editor-preview-side pre {
        background:inherit;
        margin:inherit;
    }
    .editor-preview table td,
    .editor-preview table th,
    .editor-preview-side table td,
    .editor-preview-side table th {
        border:inherit;
        padding:inherit;
    }
    .view_data_param {
        cursor: pointer;
    }
</style>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-3">
            <div class="card radius-5 border-top border-0 border-4 border-primary">
                <div class="card-body">

                    <h6>Page Navigation</h6>
                    <ul class="ps-3">
                        @if (count($pages)>0)
                            @foreach($pages as $site_page)
                            <li class="mb-1">
                                <a href="{{route("fc.page-display",[$site->id,$site_page->id])}}">
                                    <span id="spn_page_name-{{$site_page->id}}">{{$site_page->page_name}}</span>
                                </a>
                            </li>
                            @endforeach
                        @else
                            <li class="">No Pages</li>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card radius-5 border-top border-0 border-4 border-primary">
                <div class="card-body">
                    <div id="div-page-view">
                        @if (empty($default_page->content) == false)
                        {!! \Illuminate\Mail\Markdown::parse($default_page->content) !!}
                        @else
                        <p class="text-center text-danger m-4">No Content</p>
                        @endif
                    </div>
                    <div id="div-page-editor" style="display:none;">

                        <div id="div-txt-page-name" class="form-group mb-1">
                            <div class="col-lg-12">
                                {!! Form::text("txt-page-name", null,['id'=>"txt-page-name",'class'=>'form-control','placeholder'=>'Page Name','minlength'=>1,'maxlength'=>200]) !!}
                            </div>
                        </div>

                        <div id="div-page-modal-error" class="alert alert-danger" role="alert"></div>
                        <textarea id="content-page-editor" name="content-page-editor"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="{{ $control_id }}-new-page-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="lbl-{{ $control_id }}-modal-title" class="modal-title">New Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="div-{{ $control_id }}-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-{{ $control_id }}-modal" role="form" method="POST"
                        enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">

                                @csrf

                                <!-- Name Field -->
                                <div id="div-{{ $control_id }}-name" class="form-group">
                                    <label for="{{ $control_id }}-page-name"
                                        class="col-lg-3 col-form-label">Name</label>
                                    <div class="col-lg-12">
                                        {!! Form::text("{$control_id}-page-name", null, ['id' => "{$control_id}-page-name", 'class' => 'form-control', 'minlength' => 1, 'maxlength' => 1000]) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div id="div-save-page-{{ $control_id }}-modal" class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-page-{{ $control_id }}-modal" value="add">
                        <span class="spinner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        Save
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('page_scripts')

    <script src="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.js') }}"></script>
    <script src="{{ asset('hasob-foundation-core/assets/simplemde-1.11.2-dist/simplemde.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.offline').hide();
            $('.spinner').hide();
            $('#spinner').hide();

            $('#btn-new-page').show();
            $('#btn-edit-site').show();
            $('#div-page-view').show();
            $('#btn-save-page').hide();
            $('#btn-cancel-page').hide();
            $('#div-page-editor').hide();
            $('#div-page-modal-error').hide();

            @if (isset($page) && $page!=null)
            $('#btn-edit-page').show();
            @endif

            function reload_page_view(page_id){

                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $.get( "{{ route('fc-api.pages.show','') }}/"+page_id).done(function( response ) {     
                    
                    $('#spinner').hide();
                    $('#btn-new-page').show();
                    $('#btn-edit-site').show();
                    $('#div-page-view').show();
                    $('#btn-save-page').hide();
                    $('#btn-cancel-page').hide();
                    $('#div-page-editor').hide();
                    $('#div-page-modal-error').hide();

                    @if (isset($page) && $page!=null)
                    $('#btn-edit-page').show();
                    @endif

                    $('#div-page-view').empty();
                    $('#spn_page_title').empty();
                    $('#spn_page_name-'+page_id).empty();

                    if (response.data.rendered_content){
                        $('#spn_page_title').append(response.data.page_name);
                        $('#div-page-view').append(response.data.rendered_content);
                        $('#spn_page_name-'+page_id).append(response.data.page_name);
                    }

                });
            }

            $(document).on('click', "#btn-cancel-page", function(e) {
                e.preventDefault();
                reload_page_view($(this).attr('data-val'));
            });

            $(document).on('click', "#btn-save-page", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                let itemId = $(this).attr('data-val');
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('id', itemId);
                formData.append('_method', "PUT");
                formData.append('content', simplemde.value());
                formData.append('page_name', $("#txt-page-name").val());
                @if (isset($organization) && $organization!=null)
                    formData.append('organization_id', '{{$organization->id}}');
                @endif

                $.ajax({
                    url:"{{ route('fc-api.pages.update','') }}/"+itemId,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result){
                        if(result.errors){
                            $('#div-page-modal-error').html('');
                            $('#div-page-modal-error').show();
                            
                            $.each(result.errors, function(key, value){
                                console.log(value);
                                $('#div-page-modal-error').append('<li class="">'+value+'</li>');
                            });
                        }else{
                            $('#div-page-modal-error').hide();
                            window.setTimeout( function(){

                                swal({
                                    title: "Saved",
                                    text: "Page saved successfully",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: true
                                    },function(){
                                        reload_page_view(result.data.id);
                                    }
                                );

                            },20);
                        }
                    }, error: function(data){
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");
                    }
                });
            });

            $(document).on('click', "#btn-edit-page", function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                
                let itemId = $(this).attr('data-val');
                $.get( "{{ route('fc-api.pages.show','') }}/"+itemId).done(function( response ) {     
                    
                    $('#spinner').hide();
                    $('#btn-new-page').hide();
                    $('#btn-edit-site').hide();
                    $('#btn-save-page').show();
                    $('#div-page-view').hide();
                    $('#div-page-editor').show();
                    $('#btn-cancel-page').show();
                    $('#div-page-modal-error').hide();

                    @if (isset($page) && $page!=null)
                    $('#btn-edit-page').hide();
                    @endif

                    if (response.data.content){
                        simplemde.value(response.data.content);
                        $('#txt-page-name').val(response.data.page_name);
                    }

                });
            });

            $("#btn-new-page").click(function(e) {
                $('#div-{{ $control_id }}-modal-error').hide();
                $('#{{ $control_id }}-new-page-modal').modal('show');
                $('#frm-{{ $control_id }}-modal').trigger("reset");
            });

            $('#btn-save-page-{{ $control_id }}-modal').click(function(e) {

                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                $(".spinner").show();
                $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', true);

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('page_name', $('#{{ $control_id }}-page-name').val());
                formData.append('creator_user_id', "{{ Auth::id() }}");
                @if (isset($organization) && $organization != null)
                    formData.append('organization_id', '{{ $organization->id }}');
                @endif

                $.ajax({
                    url: "{{ route('fc-api.pages.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.errors) {
                            $('#div-{{ $control_id }}-modal-error').html('');
                            $('#div-{{ $control_id }}-modal-error').show();
                            $.each(result.errors, function(key, value) {
                                $('#div-{{ $control_id }}-modal-error').append('<li class="">' + value + '</li>');
                            });
                        } else {
                            $('#div-{{ $control_id }}-modal-error').hide();
                            if (result.data != null && result.data.id != null) {
                                let formData = new FormData();
                                formData.append('_token', $('input[name="_token"]').val());
                                formData.append('page_id', result.data.id);
                                formData.append('pageable_id', '{{ $site->id }}');
                                formData.append('pageable_type', String.raw`{{ get_class($site) }}`);
                                formData.append('creator_user_id', "{{ Auth::id() }}");
                                @if (isset($organization) && $organization != null)
                                    formData.append('organization_id', '{{ $organization->id }}');
                                @endif

                                $.ajax({
                                    url: "{{ route('fc-api.pageables.store') }}",
                                    type: "POST",
                                    data: formData,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    success: function(result) {},
                                    error: function(data) {},
                                });
                            }
                            $('#div-{{ $control_id }}-modal-error').hide();
                            swal({
                                title: "Saved",
                                text: "Page saved successfully",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: true
                            }, function() {
                                $('#{{ $control_id }}-new-page-modal').modal('hide');
                            });
                            window.setTimeout(function() {
                                location.reload(true);
                            }, 1000);
                        }
                        $(".spinner").hide();
                        $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', false);
                    },
                    error: function(data) {
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $(".spinner").hide();
                        $("#btn-save-page-{{ $control_id }}-modal").prop('disabled', false);
                    }
                });

            });

            //Initiate the Markdown Editor
            var simplemde = new SimpleMDE({ 
                element: $("#content-page-editor")[0],
                toolbar: [
                    {
                            name: "bold",
                            action: SimpleMDE.toggleBold,
                            className: "fa fa-bold",
                            title: "Bold",
                    },
                    {
                            name: "italic",
                            action: SimpleMDE.toggleItalic,
                            className: "fa fa-italic",
                            title: "Italic",
                    },
                    {
                            name: "strikethrough",
                            action: SimpleMDE.toggleStrikethrough,
                            className: "fa fa-strikethrough",
                            title: "Strikethrough",
                    },
                    {
                            name: "heading",
                            action: SimpleMDE.toggleHeadingSmaller,
                            className: "fa fa-header",
                            title: "Heading",
                    },
                    {
                            name: "code",
                            action: SimpleMDE.toggleCodeBlock,
                            className: "fa fa-code",
                            title: "Code",
                    },
                    "|",
                    {
                            name: "unordered-list",
                            action: SimpleMDE.toggleBlockquote,
                            className: "fa fa-list-ul",
                            title: "Generic List",
                    },
                    {
                            name: "uordered-list",
                            action: SimpleMDE.toggleOrderedList,
                            className: "fa fa-list-ol",
                            title: "Numbered List",
                    },
                    {
                            name: "clean-block",
                            action: SimpleMDE.cleanBlock,
                            className: "fa fa-eraser fa-clean-block",
                            title: "Clean block",
                    },
                    "|",
                    {
                            name: "link",
                            action: SimpleMDE.drawLink,
                            className: "fa fa-link",
                            title: "Create Link",
                    },
                    {
                            name: "image",
                            action: SimpleMDE.drawImage,
                            className: "fa fa-picture-o",
                            title: "Insert Image",
                    },
                    {
                            name: "horizontal-rule",
                            action: SimpleMDE.drawHorizontalRule,
                            className: "fa fa-minus",
                            title: "Insert Horizontal Line",
                    },
                    "|",
                    {
                        name: "button-component",
                        action: setButtonComponent,
                        className: "fa fa-hand-pointer-o",
                        title: "Button Component",
                    },
                    {
                        name: "table-component",
                        action: setTableComponent,
                        className: "fa fa-table",
                        title: "Table Component",
                    },
                    {
                        name: "promotion-component",
                        action: setPromotionComponent,
                        className: "fa fa-bullhorn",
                        title: "Promotion Component",
                    },
                    {
                        name: "panel-component",
                        action: setPanelComponent,
                        className: "fa fa-thumb-tack",
                        title: "Panel Component",
                    },
                    "|",
                    // {
                    //         name: "side-by-side",
                    //         action: SimpleMDE.toggleSideBySide,
                    //         className: "fa fa-columns no-disable no-mobile",
                    //         title: "Toggle Side by Side",
                    // },
                    // {
                    //         name: "fullscreen",
                    //         action: SimpleMDE.toggleFullScreen,
                    //         className: "fa fa-arrows-alt no-disable no-mobile",
                    //         title: "Toggle Fullscreen",
                    // },
                    {
                            name: "preview",
                            action: SimpleMDE.togglePreview,
                            className: "fa fa-eye no-disable",
                            title: "Toggle Preview",
                    },
                ],
                renderingConfig: { singleLineBreaks: true, codeSyntaxHighlighting: true,},
                hideIcons: ["guide"],
                spellChecker: false,
                promptURLs: true,
                placeholder: "Write contents here .... ",
            });

    function setButtonComponent(editor) {
        link = prompt('Button Link');
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Button Text';
        output = `
[component]: # ('mail::button',  ['url' => '`+ link +`'])
` + text + `
[endcomponent]: # 
                `;
        cm.replaceSelection(output);
    }

    function setPromotionComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Promotion Text';
        output = `
[component]: # ('mail::promotion')
` + text + `
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }

    function setPanelComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        var text = selectedText || 'Panel Text';
        output = `
[component]: # ('mail::panel')
` + text + `
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }

    function setTableComponent(editor) {
        var cm = editor.codemirror;
        var output = '';
        var selectedText = cm.getSelection();
        output = `
[component]: # ('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
[endcomponent]: # 
        `;
        cm.replaceSelection(output);
    }

            $('.preview-toggle').click(function(){
                simplemde.togglePreview();
                $(this).toggleClass('active');
            });



        });
    </script>
@endpush

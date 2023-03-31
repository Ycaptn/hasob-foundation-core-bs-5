@extends('layouts.app')

@php
$hide_right_panel = true;
@endphp


@section('title_postfix')
    {{ $site->site_name }}
@stop

@section('page_title')
    Site Manager
@stop

@section('page_title_suffix')
    {{ $site->site_name }}
@stop

@section('page_title_subtext')
    <a class="ms-10 mb-10" href="{{ route('fc.sites.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Site List
    </a>
@stop

@section('page_title_buttons')
    <span class="float-end">
        <div class="float-end inline-block dropdown mb-15">
            <a href="#" data-val='{{ $site->id }}' class='btn btn-sm btn-primary btn-edit-mdl-site-modal'>
                <i class="fa fa-edit" aria-hidden="true"></i> Edit Site
            </a>
        </div>
    </span>
@stop

@section('content')

    @php
        $artifacts = $site->site_artifacts;
        $components = $artifacts->filter(function ($value, $key) {
            return strtolower($value->type) == 'component';
        });
        $menus = $artifacts->filter(function ($value, $key) {
            return strtolower($value->type) == 'menu-item';
        });
        $templates = $artifacts->filter(function ($value, $key) {
            return strtolower($value->type) == 'template';
        });
    @endphp

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="tab-struct  custom-tab-1">
                <ul role="tablist" class="nav nav-tabs nav-primary" id="myTab">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" href="#home"
                            role="tab" aria-controls="home" aria-selected="true">Components</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pages-tab" data-bs-toggle="tab" data-bs-target="#pages" href="#pages"
                            role="tab" aria-controls="pages" aria-selected="false">Pages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images"
                            href="#images" role="tab" aria-controls="images" aria-selected="false">Graphics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#site_menu"
                            href="#menu" role="tab" aria-controls="site_menu" aria-selected="false">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="templates-tab" data-bs-toggle="tab" data-bs-target="#templates"
                            href="#templates" role="tab" aria-controls="templates" aria-selected="false">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="access-tab" data-bs-toggle="tab" data-bs-target="#access"
                            href="#access" role="tab" aria-controls="access" aria-selected="false">Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                            href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-9 mb-15">
                                            <span class="small">Components are parts of a page that make up a site.
                                                Editing a component will only affect a small part of the page where the
                                                component is displayed.</span>
                                        </div>
                                        <div class="col-md-3 mb-15">
                                            <a id="btn-site-add-component" 
                                                href="#"
                                                class="float-end btn btn-primary btn-sm btn-site-add-artifact"
                                                data-artifact-type="component"
                                                data-bs-toggle="tooltip" 
                                                title="Add New Component" >
                                                <span class="fa fa-plus-square me-2"></span> Add New Component
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-15">
                                            @include('hasob-foundation-core::sites.partials.artifacts-list', ['artifacts'=>$components])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pages" role="tabpanel" aria-labelledby="pages-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-15">
                                            <span class="small">Pages are the primary components that make up a
                                                site. Editing a page will affect the whole page and the layout of components
                                                on the page.</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 p-3">
                                            <x-hasob-foundation-core::content-editor :pageable="$site" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-15">
                                            <span class="small">Graphics such as images, videos, and audio files
                                                may be added, and can be attached in pages and components of a site.</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 p-3">
                                            <x-hasob-foundation-core::drop-zone-uploader :attachable="$site" />
                                            <x-hasob-foundation-core::picture-attachment-viewer :attachable="$site" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="site_menu" role="tabpanel" aria-labelledby="menu-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-9 mb-15">
                                            <span class="small">Menu items can be displayed on a site to direct
                                                users to sepcific pages.</span>
                                        </div>
                                        <div class="col-md-3 mb-15">
                                            <a id="btn-site-add-menu" 
                                                href="#" 
                                                class="float-end btn btn-primary btn-sm btn-site-add-artifact"
                                                data-artifact-type="menu-item"
                                                data-bs-toggle="tooltip" 
                                                title="Add New Menu">
                                                <span class="fa fa-plus-square me-2"></span> Add New Menu
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-15 p-2">
                                            @include('hasob-foundation-core::sites.partials.artifacts-list', ['artifacts'=>$menus])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="templates" role="tabpanel" aria-labelledby="templates-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-9 mb-15">
                                            <span class="small">Templates control how a page content is formated
                                                and displayed and can be applied to specific pages or all pages that form
                                                part of a site.</span>
                                        </div>
                                        <div class="col-md-3 mb-15">
                                            <a id="btn-site-add-template" 
                                                href="#"
                                                class="float-end btn btn-primary btn-sm btn-site-add-artifact"
                                                data-bs-toggle="tooltip" 
                                                data-artifact-type="template"
                                                title="Add New Template" >
                                                <span class="fa fa-plus-square me-2"></span> Add New Template
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-15 p-2">
                                            @include('hasob-foundation-core::sites.partials.artifacts-list', ['artifacts'=>$templates])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-15">
                                            <span class="fw-bold">Site View Restricted:</span> No <br/>
                                            <span class="fw-bold">Roles with View Access:</span> None <br/>
                                            <span class="fw-bold">Users with View Access:</span> None <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col-md-12 mb-15">
                                            <span class="fw-bold">Blade Rendered:</span> No <br/>
                                            <span class="fw-bold">Blade File Path:</span> N/A <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::pages.modal')
    @include('hasob-foundation-core::site_artifacts.modal')
    @include('hasob-foundation-core::sites.modal')

@endsection

@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.offline').hide();
            $('#spinner').hide();

            function prepareArtifactsModalForm() {
                $('#div-siteArtifact-modal-error').hide();
                $('#mdl-siteArtifact-modal').modal('show');
                $('#frm-siteArtifact-modal').trigger("reset");
                $('#txt-siteArtifact-primary-id').val(0);

                $('#div-show-txt-siteArtifact-primary-id').hide();
                $('#div-edit-txt-siteArtifact-primary-id').show();

                $("#spinner-site_artifacts").hide();
                $("#div-save-mdl-siteArtifact-modal").attr('disabled', false);
            }

            $(document).on('click', ".btn-site-add-artifact", function(e) {

                let artifactType = $(this).attr('data-artifact-type');
                $('#type').val(artifactType);

                if (artifactType == "component"){
                    $('#lbl-siteArtifact-modal-title').html("Add New Component");
                }else if (artifactType == "menu-item"){
                    $('#lbl-siteArtifact-modal-title').html("Add New Menu");
                }else if (artifactType == "template"){
                    $('#lbl-siteArtifact-modal-title').html("Add New Template");   
                }

                prepareArtifactsModalForm();
            });

        });
    </script>
@endpush

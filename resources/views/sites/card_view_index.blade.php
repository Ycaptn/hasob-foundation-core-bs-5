@extends('layouts.app')

@section('app_css')
    {!! $cdv_sites->render_css() !!}
@endsection

@section('title_postfix')
Sites Manager
@stop

@section('page_title')
Site
@stop

@section('page_title_suffix')
Manager
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
@stop

@section('page_title_buttons')
@if (Auth()->user()->hasAnyRole(['site-admin','admin']))
<a id="btn-site-selector-mdl-modal" class="btn btn-sm btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#mdl-select-default-site">
    <i class="fa fa-globe"></i> Default Site
</a>

<a id="btn-new-mdl-site-modal" class="btn btn-sm btn-primary btn-new-mdl-site-modal" href="#">
    <i class="fa fa-edit"></i> New&nbsp;Site
</a>
@endif
@stop

@section('content')

    <div class="row">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body">
                {{ $cdv_sites->render() }} 
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::sites.modal')
    
    <div class="modal fade" id="mdl-select-default-site" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Default Site Selector</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">

                        <div id="div-modelArtifact-modal-error" class="alert alert-danger mb-3" role="alert"></div>

                        @csrf
                            
                        <div class="offline-flag"><span class="offline-model_artifacts">You are currently offline</span></div>
                        <div id="spinner-model_artifacts" class="spinner-border text-primary" role="status"> 
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        @php
                            $default_org_site = \FoundationCore::current_organization()->artifact('default-site-id');
                        @endphp
                        <input type="hidden" id="txt-modelArtifact-primary-id" value="{{($default_org_site!=null && method_exists($default_org_site,'value'))?$default_org_site->value:'0'}}" />


                        <label class="form-label text-primary m-1">Select the default website for the organization, each organization, may have a default website deplayed as the landing page</label>

                        <div class="col-sm-12">
                            <div class="input-group">
                                <select id="site_default_selection" name="site_default_selection" class="form-select">
                                    <option value="">No Default Site Selected</option>
                                    @if (isset($all_sites) && $all_sites != null)
                                        @foreach ($all_sites as $idx=>$item)
                                            <option {{($default_org_site!=null && method_exists($default_org_site,'value') && $default_org_site->value==$item->id)?'selected':''}} value="{{$item->id}}">{{$item->site_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="input-group-text"><span class="fa fa-globe"></span></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save-site-selector-modal">Save Selection</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    {!! $cdv_sites->render_js() !!}


    <script type="text/javascript">
        $(document).ready(function() {
            
            $('.offline-model_artifacts').hide();
            $("#spinner-model_artifacts").hide();
            $('#div-modelArtifact-modal-error').hide();

            $('#btn-save-site-selector-modal').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


                //check for internet status 
                if (!window.navigator.onLine) {
                    $('.offline-model_artifacts').fadeIn(300);
                    return;
                }else{
                    $('.offline-model_artifacts').fadeOut(300);
                }

                $("#spinner-model_artifacts").show();
                $("#btn-save-site-selector-modal").attr('disabled', true);

                let actionType = "POST";
                let endPointUrl = "{{ route('fc-api.model_artifacts.store') }}";
                let primaryId = $('#txt-modelArtifact-primary-id').val();
                
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());

                if (primaryId != "0"){
                    actionType = "PUT";
                    endPointUrl = "{{ route('fc-api.model_artifacts.update','') }}/"+primaryId;
                    formData.append('id', primaryId);
                }
                
                formData.append('_method', actionType);
                @if (isset($organization) && $organization!=null)
                    formData.append('organization_id', '{{$organization->id}}');
                @endif

                formData.append('key', 'default-site-id');
                formData.append('value', $('#site_default_selection').val());
                formData.append('model_name', String.raw`{{ get_class(\FoundationCore::current_organization()) }}`);
                formData.append('model_primary_id', '{{\FoundationCore::current_organization()->id}}');

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
                            $('#div-modelArtifact-modal-error').html('');
                            $('#div-modelArtifact-modal-error').show();
                            
                            $.each(result.errors, function(key, value){
                                $('#div-modelArtifact-modal-error').append('<li class="">'+value+'</li>');
                            });
                        }else{
                            $('#div-modelArtifact-modal-error').hide();
                            window.setTimeout( function(){

                                $('#div-modelArtifact-modal-error').hide();

                                swal({
                                        title: "Saved",
                                        text: "Settings saved successfully",
                                        type: "success"
                                    },function(){
                                        location.reload(true);
                                });

                            },20);
                        }

                        $("#spinner-model_artifacts").hide();
                        $("#btn-save-site-selector-modal").attr('disabled', false);
                        
                    }, error: function(data){
                        console.log(data);
                        swal("Error", "Oops an error occurred. Please try again.", "error");

                        $("#spinner-model_artifacts").hide();
                        $("#btn-save-site-selector-modal").attr('disabled', false);
                    }
                });
            });

        });
    </script>

@endpush
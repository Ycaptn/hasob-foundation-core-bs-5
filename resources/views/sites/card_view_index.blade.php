@extends('layouts.app')

@section('app_css')
    {!! $cdv_sites->render_css() !!}
@endsection

@section('title_postfix')
Sites
@stop

@section('page_title')
Sites
@stop

@section('page_title_buttons')
<span class="pull-right">
    <a id="btn-new-mdl-site-modal" class="btn btn-xs btn-primary btn-new-mdl-site-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Site
    </a>
    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::sites.bulk-upload-modal')
    @endif
</span>
@stop

@section('content')

    <div class="row hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>

    <div class="row">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pt-5">
                    {{ $cdv_sites->render() }}
                </div>
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::sites.modal')
    
@endsection

@push('page_scripts')
    {!! $cdv_sites->render_js() !!}
@endpush
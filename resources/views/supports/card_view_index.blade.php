@extends('layouts.app')

@section('app_css')
    {!! $cdv_supports->render_css() !!}
@stop

@section('title_postfix')
Supports
@stop

@section('page_title')
Supports
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-support-modal" class="btn btn-xs btn-primary btn-new-mdl-support-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Support
    </a>
  {{--   @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::supports.bulk-upload-modal')
    @endif --}}
</span>
@stop

@section('content')

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_supports->render() }}
        </div>
    </div>
    @include('hasob-foundation-core::supports.modal')

@stop

@push('page_scripts')
    {!! $cdv_supports->render_js() !!}
@endpush
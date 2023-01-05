@extends('layouts.app')

@section('app_css')
    {!! $cdv_announcements->render_css() !!}
@stop

@section('title_postfix')
Announcements
@stop

@section('page_title')
Announcements
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-announcement-modal" class="btn btn-xs btn-primary btn-new-mdl-announcement-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Announcement
    </a>
 {{--    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::announcements.bulk-upload-modal')
    @endif --}}
</span>
@stop

@section('content')

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_announcements->render() }}
        </div>
    </div>
    @include('hasob-foundation-core::announcements.modal')

@stop

@push('page_scripts')
    {!! $cdv_announcements->render_js() !!}
@endpush
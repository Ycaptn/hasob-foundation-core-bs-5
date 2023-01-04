@extends('layouts.app')

@section('app_css')
    {!! $cdv_announcements->render_css() !!}
@endsection

@section('title_postfix')
Annoucements
@stop

@section('page_title')
Annoucements
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-announcement-modal" class="btn btn-xs btn-primary btn-new-mdl-announcement-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Announcement
    </a>
    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::announcements.bulk-upload-modal')
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
                    {{ $cdv_announcements->render() }}
                </div>
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::announcements.modal')
    
@endsection

@push('page_scripts')
    {!! $cdv_announcements->render_js() !!}
@endpush
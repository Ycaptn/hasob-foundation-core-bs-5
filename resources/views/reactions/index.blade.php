@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
All Reaction
@stop

@section('page_title')
Reaction
@stop

@section('page_title_suffix')
All Reaction
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
@stop

@section('page_title_buttons')
<a id="btn-new-mdl-reaction-modal" class="btn btn-sm btn-primary btn-new-mdl-reaction-modal">
    <i class="bx bx-book-add mr-1"></i>New Reaction
</a>
@if (Auth()->user()->hasAnyRole(['','admin']))
    @include('hasob-foundation-core::pages.reactions.bulk-upload-modal')
@endif
@stop


@section('content')
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>
    
    <div class="card">
        <div class="card-body">
        
            <div class="table-responsive">
                @include('hasob-foundation-core::pages.reactions.table')
                
            </div>
        
        </div>
    </div>

    @include('hasob-foundation-core::pages.reactions.modal')

@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">More Information</h5></div>
        <p class="small">
            This is the help message.
            This is the help message.
            This is the help message.
        </p>
    </div>
</div>
@stop

@push('page_scripts')
@endpush
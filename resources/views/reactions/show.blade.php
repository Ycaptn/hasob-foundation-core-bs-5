@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Reaction
@stop

@section('page_title')
Reaction
@stop

@section('page_title_suffix')
{{$reaction->title}}
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('attendance.reactions.index') }}">
    <i class="fa fa-angle-double-left"></i> Back to Reaction List
</a>
@stop

@section('page_title_buttons')

    <a data-toggle="tooltip" 
        title="New" 
        data-val='{{$reaction->id}}' 
        class="btn btn-sm btn-primary btn-new-mdl-reaction-modal" href="#">
        <i class="fa fa-eye"></i> New
    </a>

    <a data-toggle="tooltip" 
        title="Edit" 
        data-val='{{$reaction->id}}' 
        class="btn btn-sm btn-primary btn-edit-mdl-reaction-modal" href="#">
        <i class="fa fa-pencil-square-o"></i> Edit
    </a>

    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::pages.reactions.bulk-upload-modal')
    @endif
@stop



@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">

            @include('hasob-foundation-core::pages.reactions.modal') 
            @include('hasob-foundation-core::pages.reactions.show_fields')
            
        </div>
    </div>
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
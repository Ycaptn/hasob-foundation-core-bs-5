@extends(config('hasob-foundation-core.view_layout'))

@php
$hide_right_panel = true;
@endphp

@section('title_postfix')
    {{ $selected_checklist_name ?: 'Checklists' }}
@stop

@section('page_title')
    @if ($selected_checklist_name!=null)
    Checklist
    @else
    Application
    @endif
@stop

@section('page_title_suffix')
    @if ($selected_checklist_name!=null)
        {{ $selected_checklist_name }}
    @else
        Checklists
    @endif
@stop

@push('page_css')
@endpush

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('dashboard') }}">
        <i class="bx bx-chevron-left"></i> Back to Dashboard
    </a>
@stop

@section('page_title_buttons')
    @if (Auth()->user()->hasAnyRole(['checklist-admin', 'admin']))
        <button id="btn-new-template" type="button" class="btn btn-sm btn-primary">
            Add New Checklist
        </button>
    @endif
@stop


@section('content')

<x-hasob-foundation-core::checklist-editor />

@endsection


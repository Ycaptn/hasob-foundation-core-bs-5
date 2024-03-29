@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Departments & Units
@stop

@section('page_title')
Departments & Units
@stop

@section('page_title_suffix')
Manage Departments & Units
@stop

@section('app_css')
    {!! $cdv_departments->render_css() !!}
@stop

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('dashboard') }}">
        <i class="bx bx-chevron-left"></i> Back to Dashboard
    </a> 
@stop

@section('page_title_buttons')
    @if (Auth()->user()->hasAnyRole(['departments-admin','admin']))
    <a href="#" class="btn btn-sm btn-primary float-end btn-new-mdl-department-modal">Add Department/Unit</a>
    @endif
@stop


@section('content')
    
    <div class="card border-top border-0 border-4 border-primary" >
        <div class="card-body">
            {{ $cdv_departments->render() }}
        </div>
    </div>
@include('hasob-foundation-core::departments.modal')
@stop


@push('page_scripts')
    {!! $cdv_departments->render_js() !!}
@endpush


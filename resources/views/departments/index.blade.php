@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Departments
@stop

@section('page_title')
Departments
@stop

@section('page_title_suffix')
All
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
    <a href="#" class="btn btn-sm btn-primary float-end btn-new-mdl-department-modal">Add Department</a>
    @endif
@stop


@section('content')
    
    <div class="card  border-top  border-4 border-primary">
        <div class="card-body">
            {{ $cdv_departments->render() }}
        </div>
    </div>
@include('hasob-foundation-core::departments.modal')
@stop


@push('page_scripts')
    {!! $cdv_departments->render_js() !!}
@endpush


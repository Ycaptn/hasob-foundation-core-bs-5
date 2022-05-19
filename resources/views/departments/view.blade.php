@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
    {{ $department->long_name }}
@stop

@section('page_title')
    @if ($department->is_unit)
    Unit
    @else
    Department
    @endif
@stop

@section('page_title_suffix')
    {{ $department->long_name }}
@stop

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('fc.departments.index') }}">
        <i class="fa fa-angle-double-left"></i> Back to Departments
    </a>
@stop

@section('page_title_buttons')
    @if (Auth()->user()->hasAnyRole(['departments-admin','admin']) || $department->is_manager(Auth()->user()))
        
        <a href="#" data-toggle="tooltip" 
            title="Edit" 
            data-val="{{$department->id}}" 
            data-toggle="tooltip" 
            data-original-title="Edit"
            class="btn btn-sm btn-primary btn-edit-mdl-department-modal me-2" href="#">
            <i class="bx bxs-edit"></i> Edit
        </a>

        <a href="{{ route('fc.departments.settings',$department->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-cogs"></i> Department Settings</a>
        @include('hasob-foundation-core::departments.modal')
    @endif
@stop


@section('app_css')   
@endsection

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <p class="text-center m-4 fs-4">No site setup for this Department</p>
        </div>
    </div>

@stop


@section('side-panel')
    <x-hasob-foundation-core::department-badge :department="$department" />
    <x-hasob-foundation-core::department-members :department="$department" />
@stop



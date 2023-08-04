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


    @php
        $default_page = null;
        if (isset($department_site) && $department_site!=null){
            $pages = $department_site->pages();    
            foreach($pages as $site_page){
                if ($site_page->is_site_default_page){
                    $default_page = $site_page;
                }
            }
        }
    @endphp

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            @if (isset($department_site) && $department_site!=null)
                @if ($default_page!=null && empty($default_page->content) == false)
                    {!! \Illuminate\Mail\Markdown::parse($default_page->content) !!}
                @else
                    <p class="text-center m-4 fs-4">No Content for this Department</p>
                @endif
                <br/>
                <a href="{{ route('fc.site-display',$department_site->id) }}">{{ $department->long_name }} - Department Site</a>
            @else
                <p class="text-center m-4 fs-4">Site has not been setup for this Department</p>
            @endif
        </div>
    </div>

@stop


@section('side-panel')
    <x-hasob-foundation-core::department-badge :department="$department" />
    <x-hasob-foundation-core::department-members :department="$department" />
@stop



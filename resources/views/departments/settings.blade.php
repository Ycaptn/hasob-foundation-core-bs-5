@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
    Department Settings - {{ $department->long_name }}
@stop

@section('page_title')
    Department Settings
@stop

@section('page_title_suffix')
    {{ $department->long_name }}
@stop

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('fc.departments.show', $department->id) }}">
        <i class="fa fa-angle-double-left"></i> Back to Department
    </a>
@stop

@section('page_title_buttons')
    @if (Auth()->user()->hasAnyRole(['departments-admin', 'admin']) || $department->is_manager(Auth()->user()))
        <a href="#" data-toggle="tooltip" title="Edit" data-val="{{ $department->id }}" data-toggle="tooltip"
            data-original-title="Edit" class="btn btn-sm btn-primary btn-edit-mdl-department-modal" href="#">
            <i class="bx bxs-edit"></i> Edit
        </a>
        @include('hasob-foundation-core::departments.modal') 
        @include('hasob-foundation-core::departments.members-selector')
        
        
    @endif
@stop


@section('app_css')
    {!! $cdv_child_departments->render_css() !!}
    {!! $cdv_department_members->render_css() !!}
@stop

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">


            <div class="row">
                <div class="col-3 border-end border-0 border-3 border-info">
                    <div class="nav nav-tabs flex-column" role="tablist" id="settings_tab" aria-orientation="vertical">
                        <a id="tab_sub_units_label" class="nav-link active" data-bs-toggle="tab" href="#tab_sub_units"
                            role="tab" aria-selected="true">
                            <div class="d-flex">
                                <div class="tab-title">Sub Units</div>
                                <div class="flex-grow-1 ms-auto text-end"> <i class="bx bx-plus text-primary"></i></div>
                            </div>
                        </a>
                        <a id="tab_members_label" class="nav-link" data-bs-toggle="tab" href="#tab_members" role="tab"
                            aria-selected="true">
                            <div class="d-flex">
                                <div class="tab-title">Members</div>
                                <div class="flex-grow-1 ms-auto text-end"> <i class="bx bx-plus text-primary"></i></div>
                            </div>
                        </a>
                        <a id="tab_site_manager_label" class="nav-link" data-bs-toggle="tab" href="#tab_site_manager"
                            role="tab" aria-selected="true">
                            <div class="d-flex">
                                <div class="tab-title">Site Manager</div>
                                <div class="flex-grow-1 ms-auto text-end"> <i class="bx bx-plus text-primary"></i></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-9">
                    <div class="tab-content py-3" id="settins_tab_content">

                        <div id="tab_sub_units" class="tab-pane fade show active" role="tabpanel">
                            {{ $cdv_child_departments->render() }}
                        </div>

                        <div id="tab_members" class="tab-pane fade show" role="tabpanel">
                           {{ $cdv_department_members->render() }}      
                            @if (count($department->members) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>
                                            @foreach ($department->members as $idx => $member)
                                                <tr>
                                                    <td class="d-flex align-items-center border-top border-bottom pb-2">

                                                        @if ($member->profile_image == null)
                                                            <img width="42" height="42" class="rounded-circle p-1 border"
                                                                src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                                                        @else
                                                            <img width="42" height="42" class="rounded-circle p-1 border"
                                                                src="{{ route('fc.get-profile-picture', $member->id) }}" />
                                                        @endif
                                                    </p>
                                                    
                                                    @if (isset($member->telephone) && empty($member->telephone) == false)
                                                        <a href="tel:{{$member->telephone}}" class="me-2">
                                                            <span class="card-text small">
                                                                <i class="fa fa-phone-square gray-200"></i> {!! $member->telephone !!}
                                                            </span>
                                                        </a>
                                                    @endif

                                                    @if (isset($member->email) && empty($member->email) == false)
                                                        <a href="mailto:{{$member->email}}">
                                                            <span class="card-text small"><i class="fa fa-envelope gray-200"></i> {!! $member->email !!}</span>
                                                        </a>
                                                    @endif
                                                </div>
                                               {{--  <a href="#" data-toggle="tooltip" title="Edit" data-val="" data-toggle="tooltip" data-original-title="Edit"
                                                class="btn btn-sm btn-primary" href="#">
                                                <i class="bx bxs-edit"></i> Edit</a>&nbsp;--}}

                                                <a href="#" data-togggle="tooltip" title="Delete" data-val=""
                                                data-original-title="Delete" class="btn btn-sm btn-danger">
                                                <i class="bx bxs-trash"></i>&nbsp;Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="small text-center m-2">No Member selected for this Department.</p>
                            @endif
                        </div>

                        <div id="tab_site_manager" class="tab-pane fade show" role="tabpanel">
                            Site Manager
                        </div>

                    </div>
                </div>

            </div>



        </div>
    </div>

@stop


@section('side-panel')
    <x-hasob-foundation-core::department-badge :department="$department" />
    <x-hasob-foundation-core::department-members :department="$department" />
@stop


@push('page_scripts')
    {!! $cdv_child_departments->render_js() !!}
    {!! $cdv_department_members->render_js() !!}
@endpush
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

        @include('hasob-foundation-core::departments.departments-units-modal')
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
                <div class="col-2 border-end border-0 border-3 border-info">
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

                <div class="col-10">
                    <div class="tab-content py-3" id="settins_tab_content">

                        <div id="tab_sub_units" class="tab-pane fade show active" role="tabpanel">
                            {{ $cdv_child_departments->render() }}
                        </div>

                        <div id="tab_members" class="tab-pane fade show" role="tabpanel">
                           {{ $cdv_department_members->render() }} 

                            <div class="col-sm-12">
                                <div class="row">                                    
                                    @if (count($department->members) > 0)
                                        @foreach ($department->members as $idx => $member)

                                            <div class="col-6 col-md-6 col-sm-12">
                                                <div class="card shadow department-item">
                                                    <div class="row g-0 align-items-center">
                                                        <div class="col-xs-12 col-md-2 align-middle text-center p-2">

                                                            @if ($member->profile_image == null)
                                                                <img width="42" height="42" class="rounded-circle p-1 border"
                                                                    src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                                                            @else
                                                                <img width="42" height="42" class="rounded-circle p-1 border"
                                                                    src="{{ route('fc.get-profile-picture', $member->id) }}" />
                                                            @endif

                                                        </div>
                                                        <div class="col-xs-12 col-md-10">
                                                            <div class="card-body">
                                                                <h3 class="h6 card-title mb-0">{{ $member->full_name }}</h3>
                                                                
                                                                <div class="d-flex justify-content-between align-items-start">
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
                                                                    <span class="card-text small ms-auto">
                                                                    </span>
                                                                </div>
                                                                @include('hasob-foundation-core::departments.departments-units-modal')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="small text-center m-2">No Member selected for this Department.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="tab_site_manager" class="tab-pane fade show" role="tabpanel">
                            @if (isset($department_site) && $department_site!=null)

                                @if (Auth()->user()->hasAnyRole(['site-admin','admin']) || Auth()->user()->id == $department_site->creator_user_id)
                                <a id="btn-edit-site" href="{{route('fc.sites.show',$department_site->id)}}" data-val='{{ $department_site->id }}' class='btn btn-sm btn-primary btn-edit-mdl-site-modal'>
                                    <i class="icon wb-reply" aria-hidden="true"></i> Manage Site
                                </a>
                                @endif

                            @else
                                No Site setup for this department <br/>
                                <a id="btn-new-mdl-site-modal" class="btn btn-sm btn-primary btn-new-mdl-site-modal" href="#">
                                    <i class="fa fa-edit"></i> New&nbsp;Site
                                </a>
                                @include('hasob-foundation-core::sites.modal',['sitable_item'=>$department])
                            @endif
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

@extends(config('hasob-foundation-core.view_layout'))

@php
$hide_right_panel = true;
@endphp

@section('title_postfix')
    @if($is_edit)
    Edit User
    @else
    Create User
    @endif
@stop

@section('page_title')
    @if($is_edit)
    {{ $edited_user->full_name }}
    @else
    Create User
    @endif
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('fc.users.index') }}">
    <i class="bx bx-chevron-left"></i> Back to Users Dashboard
</a> 
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="ma-20 col-lg-11">


                <form id="frmUserDetails" name="frmUserDetails" class="form-horizontal" novalidate="" method="post" action="{{ route('fc.user.store',[ $edited_user!=null?$edited_user->id:0]) }}" enctype="multipart/form-data" >

                    {{ csrf_field() }}

                    <input type='hidden' id="idUserDetails" name="idUserDetails" value="{{ $edited_user!=null?$edited_user->id:0 }}" />

                    
                    <ul class="nav nav-tabs nav-primary" id="nav-tab" role="tablist">
                    <li class="nav-item " role="presentation">
  
                            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#details" href="#details" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-detail font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Details</div>
                                </div>
                            </a>
                        </li>

                        @if (FoundationCore::has_feature('user-presence', $organization))
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#presence" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-hourglass font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Presence Status</div>
                                    </div>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#disable" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-block font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Disable</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#roles" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-list-check font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Security Roles</div>
                                </div>
                            </a>
                        </li>
                        
                        @if (FoundationCore::has_feature('user-active-directory', $organization))
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#active-directory" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-folder-open font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Active Directory</div>
                                </div>
                            </a>
                        </li>
                        @endif

                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#others" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-cog font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Others</div>
                                </div>
                            </a>
                        </li>
                        @if($is_edit)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#raw" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="bx bx-notification font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Raw</div>
                                </div>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane fade show active"  role="tabpanel" id="details" style="margin-top:15px;">
                            <div class="row mb-3">
                                <div class="col-lg-10">
                                    <div class="">
                                        <label class="form-label">Title</label>
                                        <div class="col-lg-8">
                                            <div class="{{ $errors->has('userTitle') ? ' has-error' : '' }}">
                                                @php
                                                    $titles = ["Mr.","Mrs.","Miss.","Dr.","Arc.","Engr.","Alh.","Prof.","QS.","Mal."];
                                                @endphp
                                                <select id="userTitle" name="userTitle" class="form-select">
                                                    <option value="">N/A</option>
                                                    @foreach($titles as $title)
                                                    <option value="{{$title}}" {{$edited_user!=null&&$title==$edited_user->title?'selected':''}}>{{$title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Name</label>
                                        <div class="col-lg-8 mb-3">
                                            <div class="{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                                <input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First Name"  value="{{ $is_edit ? $edited_user->first_name : old('firstName') }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="{{ $errors->has('middleName') ? ' has-error' : '' }}">
                                                <input type="text" class="form-control" id="middleName" name="middleName"  placeholder="Middle Name"  value="{{ $is_edit ? $edited_user->middle_name : old('middleName')  }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Last Name</label>
                                        <div class="col-lg-8 mb-3">
                                            <div class="{{ $errors->has('lastName') ? ' has-error' : '' }}">
                                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Surname"  value="{{ $is_edit ? $edited_user->last_name : old('lastName')  }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <div class="col-lg-8 mb-3">
                                            <div class="input-group {{ $errors->has('emailAddress') ? ' has-error' : '' }}" >
                                                <input type='text' class="form-control" id="emailAddress" name="emailAddress" value="{{ $is_edit ? $edited_user->email : old('emailAddress')  }}" />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group {{ $errors->has('phoneNumber') ? ' has-error' : '' }}" >
                                                <input type='text' class="form-control" id="phoneNumber" name="phoneNumber" value="{{ $is_edit ? $edited_user->telephone : old('phoneNumber')  }}" placeholder="Phone Number" />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="col-lg-8 mb-3">
                                            <div class="{{ $errors->has('password1') ? ' has-error' : '' }}">
                                                <input type="password" class="form-control" id="password1" name="password1"  placeholder="Enter Password" />
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="{{ $errors->has('password1_confirmation') ? ' has-error' : '' }}">
                                                <input type="password" class="form-control" id="password1_confirmation" name="password1_confirmation" placeholder="Re-enter Password" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="form-label">Department</label>
                                        <div class="col-lg-8 mb-3">
                                            <div class="{{ $errors->has('department') ? ' has-error' : '' }}">
                                                <select id="department" name="department" class="form-select">
                                                    <option value="">Select a Department</option>
                                                @if (isset($departments))
                                                @foreach ($departments as $id=>$department)
                                                    <option value="{{$department->id}}" {{$edited_user!=null&&$department->id==$edited_user->department_id?'selected':''}}>
                                                        {{ $department->long_name }}
                                                    </option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 mb-3">
                                            <div class="input-group {{ $errors->has('jobTitle') ? ' has-error' : '' }}" >
                                                <input type='text' class="form-control" id="jobTitle" name="jobTitle" placeholder="Job Title i.e. Director, etc."  value="{{ $is_edit ? $edited_user->job_title : old('jobTitle') }}" />
                                                <!-- <span class="input-group-addon"><span class="fa fa-stack-overflow"></span></span> -->
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="file_profile_image" class="form-label">Profile Image</label>
                                        <div class="col-lg-8">
                                            <div class="{{$errors->has('profile_image')?'has-error':''}}">
                                                <input id="file_profile_image" 
                                                    type="file" 
                                                    class="form-control" 
                                                    name="file_profile_image"  
                                                    placeholder="Select File"
                                                    accept="image/*"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    

                                    <br/>
                                    <br/>
                                    <br/>
                                    @if ( $edited_user==null || $edited_user->profile_image == null )
                                        
                                    <img src="{{ asset('imgs/bare-user.png') }}" style="width:100px;height:100px;" />
                                    <br/><br/>
                                    <span class="small text-center" style="display:inline-block;">No Profile Image</span>
                                    
                                    @else
                                        <img style="width:100px;height:100px;" src="{{ route('fc.get-profile-picture',[$edited_user->id]) }}" >
                                    @endif
                                    
                                </div>
                            </div>
                        </div>

                        @if (FoundationCore::has_feature('user-presence', $organization))
                        <div role="tabpanel" class="tab-pane fade" role="tab-panel" id="presence" style="margin-top:15px;">

                            <div class="">
                                <label class="form-label">Current Status</label>
                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <select id="availability_status" name="availability_status" class="form-select">
                                            <option value="available" {{ $edited_user!=null&&$edited_user->presence_status=='available' ? 'selected' : '' }}>Available</option>
                                            <option value="on leave" {{ $edited_user!=null&&$edited_user->presence_status=='on leave' ? 'selected' : '' }}>On Leave</option>
                                            <option value="do not disturb" {{ $edited_user!=null&&$edited_user->presence_status=='do not disturb' ? 'selected' : '' }} >Do Not Disturb</option>
                                        </select>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label for="presence_comments" class="form-label">Comments</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="presence_comments" name="presence_comments" rows="5">{!! $edited_user!=null?$edited_user->leave_delegation_notes:'' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div role="tabpanel" class="tab-pane fade" role="tab-panel" id="disable" style="margin-top:15px;">

                            <div class="form-check align-items-center">
                                <label for="cbx_is_disabled" class="form-check-label">Disabled</label> 
                                <input type="checkbox" class="form-check-input" id="cbx_is_disabled" name="cbx_is_disabled" value="1" {{ $edited_user!=null&&$edited_user->is_disabled?'checked':''}} />
                            </div>

                            <div class="mb-3">
                                <label for="disable_reason" class="form-label">Disable Reason</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="disable_reason" name="disable_reason" rows="5">{!! $edited_user!=null?$edited_user->disable_reason:'' !!}</textarea>
                                </div>
                            </div>

                            @if ($edited_user != null)
                                @if ($edited_user->is_disabled && $edited_user->disabling_user)
                                <div class="">
                                    <label for="disable_reason" class="form-label">Disabled By</label>
                                    <div class="col-sm-9">
                                        {{ $edited_user->disabling_user->full_name }}
                                    </div>
                                </div>
                                <div class="">
                                    <label for="disable_reason" class="form-label">Disabled Date</label>
                                    <div class="col-sm-9">
                                        {{ $edited_user->getDisabledDateString() }}
                                    </div>
                                </div>
                                @endif
                            @endif

                        </div>

                        <div role="tabpanel" class="tab-pane fade" role="tab-panel" id="roles" style="margin-top:15px;">
                            @if (isset($all_roles) && $all_roles!=null)
                            <div class="">
                                <div class="row row-cols-3">
                                @foreach ($all_roles as $idx=>$role)
                                    <div class="col-sm-3">
                                        <div class="checkbox checkbox-success form-check">
                                            <input id='userRole_{{$role->name}}' name='userRole_{{$role->name}}' type="checkbox" value="1" class="roleCbx form-check-input" {{$edited_user!=null&&$edited_user->hasRole($role->name)?'checked':''}} />
                                            <label for="userRole_{{$role->name}}" class="form-check-label">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        @if (FoundationCore::has_feature('user-active-directory', $organization))
                        <div role="tabpanel" class="tab-pane fade" role="tab-panel" id="active-directory" style="margin-top:15px;">

                            <div class="form-check mb-3">
                                <label for="cbx_is_ad_import" class="form-check-label">AD Imported</label>
                                <!-- <div class="col-sm-9"> -->
                                    <input type="checkbox"
                                    class="form-check-input" id="cbx_is_ad_import" name="cbx_is_ad_import" value="1" {{ $edited_user!=null&&$edited_user->is_ad_import?'checked':''}} />
                                <!-- </div> -->
                            </div>

                            <div class="mb-3">
                                <label for="txt_ad_type" class="col-sm-3 form-label">AD Type</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_ad_type" name="txt_ad_type" value='{!! $edited_user!=null?$edited_user->ad_type:"" !!}' />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_ad_key" class="col-sm-3 form-label">AD Key</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_ad_key" name="txt_ad_key" value='{!! $edited_user!=null?$edited_user->ad_key:"" !!}' />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_ad_data" class="form-label">AD Data</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="txt_ad_data" name="txt_ad_data">{!! $edited_user!=null?$edited_user->ad_data:"" !!}</textarea>
                                </div>
                            </div>

                        </div>
                        @endif

                        <div role="tabpanel" class="tab-pane fade" id="others" role="tab-panel" style="margin-top:15px;">

                            <div class="mb-3">
                                <label for="txt_website" class="form-label">Website</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_website" name="txt_website" value='{!! $edited_user!=null?$edited_user->website_url:"" !!}' />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_ranking_ordinal" class="form-label">Ranking Ordinal</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_ranking_ordinal" name="txt_ranking_ordinal" value='{!! $edited_user!=null?$edited_user->ranking_ordinal:"0" !!}' />
                                </div>
                            </div>

                            
                            <div class="mb-3">
                                <label for="txt_staff_code" class="form-label">User Code</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_user_code" name="txt_user_code" value='{!! $edited_user!=null?$edited_user->user_code:"" !!}' />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_preferred_name" class="form-label">Preferred Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="txt_preferred_name" name="txt_preferred_name" value='{!! $edited_user!=null?$edited_user->preferred_name:"" !!}' />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_physical_location" class="form-label">Physical Location</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="txt_physical_location" name="txt_physical_location">{!! $edited_user!=null?$edited_user->physical_location:"" !!}</textarea>
                                </div>
                            </div>

                        </div>

                        @if($is_edit)
                            <div role="tabpanel" class="tab-pane" id="raw" style="margin-top:15px;">
                            @if ($edited_user != null)
                                {!! $edited_user->toJson(JSON_PRETTY_PRINT) !!}
                            @endif
                            </div>
                        @endif

                    </div>

                    <hr style="width: 100%;">

                    <div style="" class="">
                        <button type="submit" class="btn btn-primary me-4" id="save" name="btn_save">Save</button>

                        <a href="{{ route('fc.users.index') }}">
                            <button type="button" class="btn btn-info" id="cancel" name="btn_cancel">Cancel</button>
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>


@stop
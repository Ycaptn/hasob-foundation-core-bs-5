@extends(config('hasob-foundation-core.view_layout'))


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


@section('content')


<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="user-block">

                    <div class="row">
                        <div class="ma-20 col-lg-11">

                            <form id="frmUserDetails" name="frmUserDetails" class="form-horizontal" novalidate="" method="post" action="{{ route('fc.user.store',[ $edited_user!=null?$edited_user->id:0]) }}" enctype="multipart/form-data" >

                                {{ csrf_field() }}

                                <input type='hidden' id="idUserDetails" name="idUserDetails" value="{{ $edited_user!=null?$edited_user->id:0 }}" />

								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
                                    <li role="presentation"><a href="#presence" aria-controls="presence" role="tab" data-toggle="tab">Presence Status</a></li>
									<li role="presentation"><a href="#disable" aria-controls="disable" role="tab" data-toggle="tab">Disable</a></li>
                                    <li role="presentation"><a href="#roles" aria-controls="roles" role="tab" data-toggle="tab">Security Roles</a></li>
                                    <li role="presentation"><a href="#active-directory" aria-controls="active-directory" role="tab" data-toggle="tab">Active Directory</a></li>
                                    <li role="presentation"><a href="#others" aria-controls="others" role="tab" data-toggle="tab">Others</a></li>
                                    @if($is_edit)
                                    <li role="presentation"><a href="#raw" aria-controls="raw" role="tab" data-toggle="tab">Raw</a></li>
                                    @endif
								</ul>

								<div class="tab-content">

									<div role="tabpanel" class="tab-pane active" id="details" style="margin-top:15px;">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Title</label>
                                                    <div class="col-lg-2">
                                                        <div class="{{ $errors->has('userTitle') ? ' has-error' : '' }}">
                                                            @php
                                                                $titles = ["Mr.","Mrs.","Miss.","Dr.","Arc.","Engr.","Alh.","Prof.","QS.","Mal."];
                                                            @endphp
                                                            <select id="userTitle" name="userTitle" class="form-control">
                                                                <option value="">N/A</option>
                                                                @foreach($titles as $title)
                                                                <option value="{{$title}}" {{$edited_user!=null&&$title==$edited_user->title?'selected':''}}>{{$title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Name</label>
                                                    <div class="col-lg-4">
                                                        <div class="{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                                            <input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First Name"  value="{{ $is_edit ? $edited_user->first_name : old('firstName') }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="{{ $errors->has('middleName') ? ' has-error' : '' }}">
                                                            <input type="text" class="form-control" id="middleName" name="middleName"  placeholder="Middle Name"  value="{{ $is_edit ? $edited_user->middle_name : old('middleName')  }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Last Name</label>
                                                    <div class="col-lg-8">
                                                        <div class="{{ $errors->has('lastName') ? ' has-error' : '' }}">
                                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Surname"  value="{{ $is_edit ? $edited_user->last_name : old('lastName')  }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Email Address</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group {{ $errors->has('emailAddress') ? ' has-error' : '' }}" >
                                                            <input type='text' class="form-control" id="emailAddress" name="emailAddress" value="{{ $is_edit ? $edited_user->email : old('emailAddress')  }}" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="input-group {{ $errors->has('phoneNumber') ? ' has-error' : '' }}" >
                                                            <input type='text' class="form-control" id="phoneNumber" name="phoneNumber" value="{{ $is_edit ? $edited_user->telephone : old('phoneNumber')  }}" placeholder="Phone Number" />
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Password</label>
                                                    <div class="col-lg-4">
                                                        <div class="{{ $errors->has('password1') ? ' has-error' : '' }}">
                                                            <input type="password" class="form-control" id="password1" name="password1"  placeholder="Enter Password" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="{{ $errors->has('password1_confirmation') ? ' has-error' : '' }}">
                                                            <input type="password" class="form-control" id="password1_confirmation" name="password1_confirmation" placeholder="Re-enter Password" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-3 control-label">Department</label>
                                                    <div class="col-lg-4">
                                                        <div class="{{ $errors->has('department') ? ' has-error' : '' }}">
                                                            <select id="department" name="department" class="form-control">
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
                                                    <div class="col-lg-4">
                                                        <div class="input-group {{ $errors->has('jobTitle') ? ' has-error' : '' }}" >
                                                            <input type='text' class="form-control" id="jobTitle" name="jobTitle" placeholder="Job Title i.e. Director, etc."  value="{{ $is_edit ? $edited_user->job_title : old('jobTitle') }}" />
                                                            <span class="input-group-addon"><span class="fa fa-stack-overflow"></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="file_profile_image" class="col-lg-3 control-label">Profile Image</label>
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
                                                    <img style="width:100px;height:100px;" src="{{ route('school-picture-staff',[$edited_user->id]) }}" >
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="presence" style="margin-top:15px;">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Current Status</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select id="availability_status" name="availability_status" class="form-control">
                                                        <option value="available" {{ $edited_user!=null&&$edited_user->presence_status=='available' ? 'selected' : '' }}>Available</option>
                                                        <option value="on leave" {{ $edited_user!=null&&$edited_user->presence_status=='on leave' ? 'selected' : '' }}>On Leave</option>
                                                        <option value="do not disturb" {{ $edited_user!=null&&$edited_user->presence_status=='do not disturb' ? 'selected' : '' }} >Do Not Disturb</option>
                                                    </select>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="presence_comments" class="col-sm-3 control-label">Comments</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" id="presence_comments" name="presence_comments" rows="5">{!! $edited_user!=null?$edited_user->leave_delegation_notes:'' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="disable" style="margin-top:15px;">

                                        <div class="form-group">
                                            <label for="cbx_is_disabled" class="col-sm-3 control-label">Disabled</label>
                                            <div class="col-sm-9">
                                                <input type="checkbox" id="cbx_is_disabled" name="cbx_is_disabled" value="1" {{ $edited_user!=null&&$edited_user->is_disabled?'checked':''}} />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="disable_reason" class="col-sm-3 control-label">Disable Reason</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" id="disable_reason" name="disable_reason" rows="5">{!! $edited_user!=null?$edited_user->disable_reason:'' !!}</textarea>
                                            </div>
                                        </div>

                                        @if ($edited_user != null)
                                            @if ($edited_user->is_disabled && $edited_user->disabling_user)
                                            <div class="form-group">
                                                <label for="disable_reason" class="col-sm-3 control-label">Disabled By</label>
                                                <div class="col-sm-9">
                                                    {{ $edited_user->disabling_user->full_name }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="disable_reason" class="col-sm-3 control-label">Disabled Date</label>
                                                <div class="col-sm-9">
                                                    {{ $edited_user->getDisabledDateString() }}
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="roles" style="margin-top:15px;">
                                        @if (isset($all_roles) && $all_roles!=null)
                                        <div class="form-group">
                                            <div class="col-xs-12">
                                            @foreach ($all_roles as $idx=>$role)
                                                <div class="col-xs-3">
                                                    <div class="checkbox checkbox-success">
														<input id='userRole_{{$role->name}}' name='userRole_{{$role->name}}' type="checkbox" value="1" class="roleCbx" {{$edited_user!=null&&$edited_user->hasRole($role->name)?'checked':''}} />
														<label for="userRole_{{$role->name}}">
															{{ $role->name }}
														</label>
													</div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="active-directory" style="margin-top:15px;">

                                        <div class="form-group">
                                            <label for="cbx_is_ad_import" class="col-sm-3 control-label">AD Imported</label>
                                            <div class="col-sm-9">
                                                <input type="checkbox" id="cbx_is_ad_import" name="cbx_is_ad_import" value="1" {{ $edited_user!=null&&$edited_user->is_ad_import?'checked':''}} />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_ad_type" class="col-sm-3 control-label">AD Type</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_ad_type" name="txt_ad_type" value='{!! $edited_user!=null?$edited_user->ad_type:"" !!}' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_ad_key" class="col-sm-3 control-label">AD Key</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_ad_key" name="txt_ad_key" value='{!! $edited_user!=null?$edited_user->ad_key:"" !!}' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_ad_data" class="col-sm-3 control-label">AD Data</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" id="txt_ad_data" name="txt_ad_data">{!! $edited_user!=null?$edited_user->ad_data:"" !!}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="others" style="margin-top:15px;">

                                        <div class="form-group">
                                            <label for="txt_website" class="col-sm-3 control-label">Website</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_website" name="txt_website" value='{!! $edited_user!=null?$edited_user->website_url:"" !!}' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_ranking_ordinal" class="col-sm-3 control-label">Ranking Ordinal</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_ranking_ordinal" name="txt_ranking_ordinal" value='{!! $edited_user!=null?$edited_user->ranking_ordinal:"0" !!}' />
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="txt_staff_code" class="col-sm-3 control-label">User Code</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_user_code" name="txt_user_code" value='{!! $edited_user!=null?$edited_user->user_code:"" !!}' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_preferred_name" class="col-sm-3 control-label">Preferred Name</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="txt_preferred_name" name="txt_preferred_name" value='{!! $edited_user!=null?$edited_user->preferred_name:"" !!}' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="txt_physical_location" class="col-sm-3 control-label">Physical Location</label>
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

								<div style="width: 75%; margin-left: auto">
									<button type="submit" class="btn btn-warning" id="save" name="btn_save">Save</button>

									<a href="{{ route('fc.users.index') }}">
										<button type="button" class="btn btn-primary" id="cancel" name="btn_cancel">Cancel</button>
									</a>
								</div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</div>


@stop
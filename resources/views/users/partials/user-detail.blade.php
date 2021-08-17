
<form id="frmUserDetails" name="frmUserDetails" class="form-horizontal" novalidate="">

    {{ csrf_field() }}

    <div id="spinner1" class="">
        <div class="loader" id="loader-1"></div>
    </div>

    <div id="errorMsgUserDetails" class="alert alert-danger ma-10 mb-20"></div>

    <input type='hidden' id="idUserDetails" name="idUserDetails" />

    <div class="form-group">
        <label class="col-lg-3 control-label">Title</label>
        <div class="col-lg-2">
            <div class="{{ $errors->has('userTitle') ? ' has-error' : '' }}">
                <select id="userTitle" name="userTitle" class="form-control">
                    <option value="">N/A</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Arc.">Arc.</option>
                    <option value="Engr.">Engr.</option>
                    <option value="Alh.">Alh.</option>
                    <option value="Miss.">Miss</option>
                    <option value="Prof.">Prof</option>
                    <option value="QS.">QS.</option>
                    <option value="Mal.">Mallam</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Name</label>
        <div class="col-lg-3">
            <div class="{{ $errors->has('firstName') ? ' has-error' : '' }}">
                <input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First Name" autofocus />
            </div>
        </div>
        <div class="col-lg-3">
            <div class="{{ $errors->has('middleName') ? ' has-error' : '' }}">
                <input type="text" class="form-control" id="middleName" name="middleName"  placeholder="Middle Name" autofocus />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Last Name</label>
        <div class="col-lg-6">
            <div class="{{ $errors->has('lastName') ? ' has-error' : '' }}">
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Surname" />
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-3 control-label">Email Address</label>
        <div class="col-lg-6">
            <div class="input-group {{ $errors->has('emailAddress') ? ' has-error' : '' }}" >
                <input type='text' class="form-control" id="emailAddress" name="emailAddress" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Telephone</label>
        <div class="col-lg-6">
            <div class="input-group {{ $errors->has('phoneNumber') ? ' has-error' : '' }}" >
                <input type='text' class="form-control" id="phoneNumber" name="phoneNumber" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Password</label>
        <div class="col-lg-3">
        <div class="{{ $errors->has('password1') ? ' has-error' : '' }}">
            <input type="password" autocomplete="off" class="form-control" id="password1" name="password1"  placeholder="Enter Password" />
        </div>
        </div>
        <div class="col-lg-3">
            <div class="{{ $errors->has('password1_confirmation') ? ' has-error' : '' }}">
            <input type="password" autocomplete="off" class="form-control" id="password1_confirmation" name="password1_confirmation" placeholder="Re-enter Password" />
            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-3 control-label">Department</label>
        <div class="col-lg-6">
        <div class="{{ $errors->has('department') ? ' has-error' : '' }}">
            <select id="department" name="department" class="form-control">
            <option value="0">Select a Department</option>
            @if (isset($departments))
            @foreach ($departments as $id=>$department)
                <option value="{{$department->id}}">{{ $department->long_name }}</option>
            @endforeach
            @endif
            </select>
        </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">Job Title</label>
        <div class="col-lg-6">
        <div class="input-group {{ $errors->has('jobTitle') ? ' has-error' : '' }}" >
            <input type='text' class="form-control" id="jobTitle" name="jobTitle" placeholder="Director, etc." />
            <span class="input-group-addon"><span class="fa fa-stack-overflow"></span></span>
        </div>
        </div>
    </div>

    @if (isset($allRoles) && $allRoles!=null)
    <div class="form-group">
        <label class="col-xs-3 control-label">Security Role</label>
        <div class="col-xs-9">
        @foreach ($allRoles as $idx=>$role)
            <div class="col-xs-6">
                <div class="checkbox">
                    <label>
                        <input id='userRole{{$role->name}}' name='userRole{{$role->name}}' type="checkbox" value="0" class="roleCbx" /> {{ $role->name }}
                    </label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endif

<br/>
<br/>


</form>




@push('page_scripts')

    @include('hasob-foundation-core::users.partials.user-editing-js')

    <script type="text/javascript">

        $('#spinner1').hide();

        $(document).ready(function(){

            $('#idUserDetails').val('{!! Auth::guard('web')->user()->id !!}');

            $('#userTitle').val(null);
            $('#firstName').val(null);
            $('#middleName').val(null);
            $('#lastName').val(null);
            $('#phoneNumber').val(null);
            $('#emailAddress').val(null);
            $('#department').val(null);
            $('#jobTitle').val(null);

            $('#spinner1').show();
            $('#btnSaveUserDetails').prop("disabled", true);


            $.get( "{{ route('fc.user.show', Auth::guard('web')->user()->id ) }}").done(function( data ) {
                $('#userTitle').val(data.title);
                $('#firstName').val(data.first_name);
                $('#middleName').val(data.middle_name);
                $('#lastName').val(data.last_name);
                $('#phoneNumber').val(data.telephone);
                $('#emailAddress').val(data.email);
                $('#department').val(data.department_id);
                $('#jobTitle').val(data.job_title);

                $('#spinner1').hide();
                $('#btnSaveUserDetails').prop("disabled", false);
            });
        });
    </script>

@endpush
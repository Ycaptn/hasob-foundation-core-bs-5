<form id="frmUserDetails" name="frmUserDetails" class="form-horizontal" novalidate="">

    {{ csrf_field() }}

    <input type='hidden' id="idUserDetails" name="idUserDetails" />

    <div class="mb-3">
        <label class="form-label">Title</label>
        <div class="col-lg-2" style="padding-top:7px">
            {{ Auth::guard('web')->user()->title }}
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <div class="col-lg-3" style="padding-top:7px">
            {{ Auth::guard('web')->user()->first_name }}
        </div>
        <div class="col-lg-3">
            {{ Auth::guard('web')->user()->middle_name }}
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Last Name</label>
        <div class="col-lg-6" style="padding-top:7px">
            {{ Auth::guard('web')->user()->last_name }}
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Telephone</label>
        <div class="col-lg-6" style="padding-top:7px">
            {{ Auth::guard('web')->user()->telephone }}
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="col-lg-6" style="padding-top:7px">
            {{ Auth::guard('web')->user()->email }}
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="col-lg-3" style="padding-top:7px">******</div>
    </div>


    <div class="mb-3">
        <label class="form-label">Department</label>
        <div class="col-lg-6" style="padding-top:7px">
            @if (Auth::guard('web')->user()->department != null)
            {{ strtoupper(Auth::guard('web')->user()->department->long_name) }}
            @endif
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Job Title</label>
        <div class="col-lg-6" style="padding-top:7px">
            {{ Auth::guard('web')->user()->job_title }}
        </div>
    </div>

</form>


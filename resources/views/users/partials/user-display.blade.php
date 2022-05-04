@php
$current_user = Auth::user();
@endphp

<form id="frmUserDetails" name="frmUserDetails" class="form-horizontal" novalidate="">

    {{ csrf_field() }}

    <input type='hidden' id="idUserDetails" name="idUserDetails" />

    <div class="mb-3 d-flex " style="padding-top:7px">
    <div class='me-3'>
        <strong>Name</strong>

    </div>
       <div >
            {{ $current_user->title }}
            {{ $current_user->first_name }}
            {{ $current_user->middle_name }}
            {{ $current_user->last_name }}
        </div>
    </div>

     <div class="mb-3 d-flex " style="padding-top:7px">
    <div class='me-3'>
            <strong>Telephone</strong>

        </div>
        <div>
            {{ $current_user->telephone }}

        </div>
        
    </div>

    <div class="mb-3 d-flex " style="padding-top:7px">
    <div class='me-3'>
            <strong class="form-label">Email Address</strong>

        </div>
       <div>

           {{ $current_user->email }}
       </div>
       
    </div>
    {{-- <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="col-lg-3" style="padding-top:7px">******</div>
    </div> --}}

<div class="mb-3 d-flex align-items-center " style="padding-top:7px">
    <div class='me-3'>

            <strong class="form-label">Department</strong>
        </div>
        <div>
            @if ($current_user->department != null)
            {{ strtoupper($current_user->department->long_name) }}
            @endif

        </div>
    </div>

    <div class="mb-3 d-flex align-items-center " style="padding-top:7px">
    <div class='me-3'>
            <strong class="form-label">Job Title</strong>

        </div>
        <div>
            {{ $current_user->job_title }}

        </div>
    </div>

</form>

   

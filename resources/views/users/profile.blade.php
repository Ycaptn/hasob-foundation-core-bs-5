@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
User Profile
@stop

@section('page_title')
User Profile
<p>View and modify your profile details.</p>
@stop


@section('content')

    

    <div class="row">

        <div class="col-md-4">
            @include('hasob-foundation-core::users.partials.user-badge')
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user fa-fw"></i>Profile Details

                    <div class="pull-right">
                        @if ($edit_mode == false)
                        <a href="{{ route('fc.users.profile','edit=1') }}" >
                            <button id="btn-add" type="button" class="btn btn-warning btn-xs">
                                Modify
                            </button>
                        </a>
                        @endif
                    </div>

                </div>
                <div class="panel-body">

                    @if ($edit_mode == false)
                        @include('hasob-foundation-core::users.partials.user-display')
                    @else
                        @include('hasob-foundation-core::users.partials.user-detail')

                        <div class="col-xs-9 col-xs-offset-3">
                            <button data-val="{{Auth::id()}}" type="button" class="btn btn-primary" id="btnSaveUserDetails">  <span class="glyphicon glyphicon-ok"></span> &nbsp;Save Changes</button>

                            <a href="{{ route('fc.users.profile') }}">
                                <button type="button" class="btn btn-warning"> <span class="glyphicon glyphicon-remove"></span> Cancel </button>
                            </a>

                        </div>
                        <br/>
                    @endif

                    <br/>                
                </div>
            </div>
        </div>


    </div>

@stop


@push('page_scripts')

    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>    

@endpush
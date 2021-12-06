@extends('layouts.app')


@section('title_postfix')
Settings
@stop

@section('page_title')
Settings
@stop

@section('page_title_buttons')
<span class="pull-right">
    <a id="btn-new-mdl-setting-modal" class="btn btn-xs btn-primary pull-right btn-new-mdl-setting-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Setting
    </a>
</span>
@stop


@section('content')
    
    <div class="row hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>

    <div class="row">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('hasob-scola-gradebook::pages.settings.table')
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('hasob-scola-gradebook::pages.settings.modal')

@endsection

@push('page_scripts')
@endpush
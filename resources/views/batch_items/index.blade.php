@extends('layouts.app')


@section('title_postfix')
Batch Items
@stop

@section('page_title')
Batch Items
@stop

@section('page_title_buttons')
<span class="pull-right">
    <a id="btn-new-mdl-batchItem-modal" class="btn btn-xs btn-primary btn-new-mdl-batchItem-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Batch Item
    </a>
    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-scola-gradebook::pages.batch_items.bulk-upload-modal')
    @endif
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
                            @include('hasob-scola-gradebook::pages.batch_items.table')
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('hasob-scola-gradebook::pages.batch_items.modal')

@endsection

@push('page_scripts')
@endpush
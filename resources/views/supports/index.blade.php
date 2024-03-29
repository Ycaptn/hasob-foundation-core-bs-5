@extends('layouts.app')


@section('title_postfix')
Support
@stop

@section('page_title')
Support
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-supports-modal" class="btn btn-xs btn-primary btn-new-mdl-support-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Support
    </a>
    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::pages.supports.bulk-upload-modal')
    @endif
</span>
@stop


@section('content')
    
    <div class="row hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>

    <div class="row">
        <div class="card">
            <div class="card-wrapper collapse in">
                <div class="card-body">

                    <div class="table-wrap">
                        <div class="table-responsive">
                            @include('hasob-foundation-core::pages.supports.table')
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::pages.supports.modal')

@endsection

@push('page_scripts')
@endpush
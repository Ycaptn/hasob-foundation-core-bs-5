@extends('layouts.app')


@section('title_postfix')
Annoucement
@stop

@section('page_title')
Annoucement
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-annoucements-modal" class="btn btn-xs btn-primary btn-new-mdl-annoucement-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> New&nbsp;Annoucement
    </a>
    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-foundation-core::pages.annoucements.bulk-upload-modal')
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
                            @include('hasob-foundation-core::pages.annoucements.table')
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::pages.annoucements.modal')

@endsection

@push('page_scripts')
@endpush
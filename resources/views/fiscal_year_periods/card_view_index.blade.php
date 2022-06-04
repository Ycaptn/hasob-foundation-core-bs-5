@extends('layouts.app')

@section('app_css')
    {!! $cdv_fiscal_year_periods->render_css() !!}
@stop

@section('title_postfix')
Fiscal Year Periods
@stop

@section('page_title')
Fiscal Year Periods
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a>
@stop

@section('page_title_buttons')
<a id="btn-new-mdl-fiscalYearPeriod-modal" class="btn btn-primary btn-new-mdl-fiscalYearPeriod-modal">
    <i class="bx bx-book-add mr-1"></i>New Fiscal Year Period
</a>
@if (Auth()->user()->hasAnyRole(['','admin']))
    @include('hasob-lab-manager-module::pages.fiscal_year_periods.bulk-upload-modal')
@endif
@stop

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_fiscal_year_periods->render() }}
        </div>
    </div>

    @include('hasob-lab-manager-module::pages.fiscal_year_periods.modal')
@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">More Information</h5></div>
        <p class="small">
            This is the help message.
            This is the help message.
            This is the help message.
        </p>
    </div>
</div>
@stop

@push('page_scripts')
    {!! $cdv_fiscal_year_periods->render_js() !!}
@endpush
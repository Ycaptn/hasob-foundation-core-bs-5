@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Fiscal Year Period Details
@stop

@section('page_title')
Fiscal Year Period Details
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('fiscalYearPeriods.index') }}">
    <i class="bx bx-chevron-left"></i> Back to Fiscal Year Period Dashboard
</a>
@stop

@section('page_title_buttons')

    <a data-toggle="tooltip" 
        title="New" 
        data-val='{{$id}}' 
        class="btn btn-primary btn-new-mdl-fiscalYearPeriod-modal" href="#">
        <i class="fa fa-eye text-primary" style="opacity:80%"></i>
    </a>

    <a data-toggle="tooltip" 
        title="Edit" 
        data-val='{{$id}}' 
        class="btn btn-primary btn-edit-mdl-fiscalYearPeriod-modal" href="#">
        <i class="fa fa-pencil-square-o text-primary" style="opacity:80%"></i>
    </a>

    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('hasob-lab-manager-module::pages.fiscal_year_periods.bulk-upload-modal')
    @endif
@stop


@section('page_title_subtext')
    <a class="ml-10 mb-10" href="{{ route('lm.fiscalYearPeriods.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Fiscal Year Period List
    </a>
@stop


@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            @include('hasob-lab-manager-module::pages.fiscal_year_periods.show_fields')
            
        </div>
    </div>
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
@endpush
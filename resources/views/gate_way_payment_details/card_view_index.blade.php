@extends('layouts.app')

@section('app_css')
    {!! $cdv_gate_way_payment_details->render_css() !!}
@stop

@section('title_postfix')
Gate Way Payment Details
@stop

@section('page_title')
Gate Way Payment Details
@stop

@section('page_title_suffix')
All Gate Way Payment Details
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a>
@stop

@section('page_title_buttons')
<a id="btn-new-mdl-gateWayPaymentDetail-modal" class="btn btn-sm btn-primary btn-new-mdl-gateWayPaymentDetail-modal">
    <i class="bx bx-book-add me-1"></i>New Gate Way Payment Detail
</a>
@if (Auth()->user()->hasAnyRole(['','admin']))
    @include('tetfund-attendance-module::pages.gate_way_payment_details.bulk-upload-modal')
@endif
@stop

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 hidden-sm hidden-xs">
        {{-- Summary Row --}}
    </div>
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_gate_way_payment_details->render() }}
        </div>
    </div>

    @include('tetfund-attendance-module::pages.gate_way_payment_details.modal')
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
    {!! $cdv_gate_way_payment_details->render_js() !!}
@endpush
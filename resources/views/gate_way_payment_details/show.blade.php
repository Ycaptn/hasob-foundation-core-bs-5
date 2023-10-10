@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Gate Way Payment Detail
@stop

@section('page_title')
Gate Way Payment Detail
@stop

@section('page_title_suffix')
{{$gateWayPaymentDetail->title}}
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('tetf-att.gateWayPaymentDetails.index') }}">
    <i class="fa fa-angle-double-left"></i> Back to Gate Way Payment Detail List
</a>
@stop

@section('page_title_buttons')

    <a data-toggle="tooltip" 
        title="New" 
        data-val='{{$gateWayPaymentDetail->id}}' 
        class="btn btn-sm btn-primary btn-new-mdl-gateWayPaymentDetail-modal" href="#">
        <i class="fa fa-eye"></i> New
    </a>

    <a data-toggle="tooltip" 
        title="Edit" 
        data-val='{{$gateWayPaymentDetail->id}}' 
        class="btn btn-sm btn-primary btn-edit-mdl-gateWayPaymentDetail-modal" href="#">
        <i class="fa fa-pencil-square-o"></i> Edit
    </a>

    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('tetfund-tetf-att-module::pages.gate_way_payment_details.bulk-upload-modal')
    @endif
@stop



@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">

            @include('tetfund-hasob-foundation-core::pages.gate_way_payment_details.modal') 
            @include('tetfund-hasob-foundation-core::pages.gate_way_payment_details.show_fields')
            
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
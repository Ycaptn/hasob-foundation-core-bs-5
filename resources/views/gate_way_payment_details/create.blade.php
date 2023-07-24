@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Create Gate Way Payment Detail
@stop

@section('page_title')
Create Gate Way Payment Detail
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('fc.gateWayPaymentDetails.index') }}">
    <i class="bx bx-chevron-left"></i> Back to Gate Way Payment Detail Dashboard
</a>
@stop

@section('page_title_buttons')
{{--
<a id="btn-new-mdl-gateWayPaymentDetail-modal" class="btn btn-sm btn-primary btn-new-mdl-gateWayPaymentDetail-modal">
    <i class="bx bx-book-add me-1"></i>New Gate Way Payment Detail
</a>
--}}
@stop

@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body p-4">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-user me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Gate Way Payment Detail Details</h5>
            </div>
            <hr />
            {!! Form::open(['route' => 'fc.gateWayPaymentDetails.store','class'=>'form-horizontal']) !!}
            
                @include('hasob-foundationcore.gate_way_payment_details.fields')

                <div class="col-lg-offset-3 col-lg-9">
                    <hr />
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ route('fc.gateWayPaymentDetails.index') }}" class="btn btn-default btn-warning">Cancel</a>
                </div>

            {!! Form::close() !!}
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
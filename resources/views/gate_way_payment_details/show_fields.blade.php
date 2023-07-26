<!-- Payable Type Field -->
<div id="div_gateWayPaymentDetail_payable_type" class="col-lg-12">
    <p>
        {!! Form::label('payable_type', 'Payable Type:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_payable_type">
        @if (isset($gateWayPaymentDetail->payable_type) && empty($gateWayPaymentDetail->payable_type)==false)
            {!! $gateWayPaymentDetail->payable_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Payable Id Field -->
<div id="div_gateWayPaymentDetail_payable_id" class="col-lg-12">
    <p>
        {!! Form::label('payable_id', 'Payable Id:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_payable_id">
        @if (isset($gateWayPaymentDetail->payable_id) && empty($gateWayPaymentDetail->payable_id)==false)
            {!! $gateWayPaymentDetail->payable_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Type Field -->
<div id="div_gateWayPaymentDetail_type" class="col-lg-12">
    <p>
        {!! Form::label('type', 'Type:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_type">
        @if (isset($gateWayPaymentDetail->type) && empty($gateWayPaymentDetail->type)==false)
            {!! $gateWayPaymentDetail->type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Account Number Field -->
<div id="div_gateWayPaymentDetail_bank_account_number" class="col-lg-12">
    <p>
        {!! Form::label('bank_account_number', 'Bank Account Number:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_bank_account_number">
        @if (isset($gateWayPaymentDetail->bank_account_number) && empty($gateWayPaymentDetail->bank_account_number)==false)
            {!! $gateWayPaymentDetail->bank_account_number !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Name Field -->
<div id="div_gateWayPaymentDetail_bank_name" class="col-lg-12">
    <p>
        {!! Form::label('bank_name', 'Bank Name:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_bank_name">
        @if (isset($gateWayPaymentDetail->bank_name) && empty($gateWayPaymentDetail->bank_name)==false)
            {!! $gateWayPaymentDetail->bank_name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Sort Code Field -->
<div id="div_gateWayPaymentDetail_bank_sort_code" class="col-lg-12">
    <p>
        {!! Form::label('bank_sort_code', 'Bank Sort Code:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_bank_sort_code">
        @if (isset($gateWayPaymentDetail->bank_sort_code) && empty($gateWayPaymentDetail->bank_sort_code)==false)
            {!! $gateWayPaymentDetail->bank_sort_code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Account Gateway Code Field -->
<div id="div_gateWayPaymentDetail_account_gateway_code" class="col-lg-12">
    <p>
        {!! Form::label('account_gateway_code', 'Account Gateway Code:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_account_gateway_code">
        @if (isset($gateWayPaymentDetail->account_gateway_code) && empty($gateWayPaymentDetail->account_gateway_code)==false)
            {!! $gateWayPaymentDetail->account_gateway_code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_gateWayPaymentDetail_status" class="col-lg-12">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_status">
        @if (isset($gateWayPaymentDetail->status) && empty($gateWayPaymentDetail->status)==false)
            {!! $gateWayPaymentDetail->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Currency Field -->
<div id="div_gateWayPaymentDetail_currency" class="col-lg-12">
    <p>
        {!! Form::label('currency', 'Currency:', ['class'=>'control-label']) !!} 
        <span id="spn_gateWayPaymentDetail_currency">
        @if (isset($gateWayPaymentDetail->currency) && empty($gateWayPaymentDetail->currency)==false)
            {!! $gateWayPaymentDetail->currency !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


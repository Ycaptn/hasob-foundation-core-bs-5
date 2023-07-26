<!-- Amount Field -->
<div id="div_paymentDisbursement_amount" class="col-lg-12">
    <p>
        {!! Form::label('amount', 'Amount:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_amount">
        @if (isset($paymentDisbursement->amount) && empty($paymentDisbursement->amount)==false)
            {!! $paymentDisbursement->amount !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Payable Type Field -->
<div id="div_paymentDisbursement_payable_type" class="col-lg-12">
    <p>
        {!! Form::label('payable_type', 'Payable Type:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_payable_type">
        @if (isset($paymentDisbursement->payable_type) && empty($paymentDisbursement->payable_type)==false)
            {!! $paymentDisbursement->payable_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Payable Id Field -->
<div id="div_paymentDisbursement_payable_id" class="col-lg-12">
    <p>
        {!! Form::label('payable_id', 'Payable Id:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_payable_id">
        @if (isset($paymentDisbursement->payable_id) && empty($paymentDisbursement->payable_id)==false)
            {!! $paymentDisbursement->payable_id !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Account Number Field -->
<div id="div_paymentDisbursement_bank_account_number" class="col-lg-12">
    <p>
        {!! Form::label('bank_account_number', 'Bank Account Number:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_bank_account_number">
        @if (isset($paymentDisbursement->bank_account_number) && empty($paymentDisbursement->bank_account_number)==false)
            {!! $paymentDisbursement->bank_account_number !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Name Field -->
<div id="div_paymentDisbursement_bank_name" class="col-lg-12">
    <p>
        {!! Form::label('bank_name', 'Bank Name:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_bank_name">
        @if (isset($paymentDisbursement->bank_name) && empty($paymentDisbursement->bank_name)==false)
            {!! $paymentDisbursement->bank_name !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Bank Sort Code Field -->
<div id="div_paymentDisbursement_bank_sort_code" class="col-lg-12">
    <p>
        {!! Form::label('bank_sort_code', 'Bank Sort Code:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_bank_sort_code">
        @if (isset($paymentDisbursement->bank_sort_code) && empty($paymentDisbursement->bank_sort_code)==false)
            {!! $paymentDisbursement->bank_sort_code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Gateway Reference Code Field -->
<div id="div_paymentDisbursement_gateway_reference_code" class="col-lg-12">
    <p>
        {!! Form::label('gateway_reference_code', 'Gateway Reference Code:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_gateway_reference_code">
        @if (isset($paymentDisbursement->gateway_reference_code) && empty($paymentDisbursement->gateway_reference_code)==false)
            {!! $paymentDisbursement->gateway_reference_code !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Status Field -->
<div id="div_paymentDisbursement_status" class="col-lg-12">
    <p>
        {!! Form::label('status', 'Status:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_status">
        @if (isset($paymentDisbursement->status) && empty($paymentDisbursement->status)==false)
            {!! $paymentDisbursement->status !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Gateway Initialization Response Field -->
<div id="div_paymentDisbursement_gateway_initialization_response" class="col-lg-12">
    <p>
        {!! Form::label('gateway_initialization_response', 'Gateway Initialization Response:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_gateway_initialization_response">
        @if (isset($paymentDisbursement->gateway_initialization_response) && empty($paymentDisbursement->gateway_initialization_response)==false)
            {!! $paymentDisbursement->gateway_initialization_response !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Payment Instrument Type Field -->
<div id="div_paymentDisbursement_payment_instrument_type" class="col-lg-12">
    <p>
        {!! Form::label('payment_instrument_type', 'Payment Instrument Type:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_payment_instrument_type">
        @if (isset($paymentDisbursement->payment_instrument_type) && empty($paymentDisbursement->payment_instrument_type)==false)
            {!! $paymentDisbursement->payment_instrument_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Payment Instrument Type Field -->
<div id="div_paymentDisbursement_payment_instrument_type" class="col-lg-12">
    <p>
        {!! Form::label('payment_instrument_type', 'Payment Instrument Type:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_payment_instrument_type">
        @if (isset($paymentDisbursement->payment_instrument_type) && empty($paymentDisbursement->payment_instrument_type)==false)
            {!! $paymentDisbursement->payment_instrument_type !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Is Verified Field -->
<div id="div_paymentDisbursement_is_verified" class="col-lg-12">
    <p>
        {!! Form::label('is_verified', 'Is Verified:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_is_verified">
        @if (isset($paymentDisbursement->is_verified) && empty($paymentDisbursement->is_verified)==false)
            {!! $paymentDisbursement->is_verified !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Is Verification Passed Field -->
<div id="div_paymentDisbursement_is_verification_passed" class="col-lg-12">
    <p>
        {!! Form::label('is_verification_passed', 'Is Verification Passed:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_is_verification_passed">
        @if (isset($paymentDisbursement->is_verification_passed) && empty($paymentDisbursement->is_verification_passed)==false)
            {!! $paymentDisbursement->is_verification_passed !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Is Verification Failed Field -->
<div id="div_paymentDisbursement_is_verification_failed" class="col-lg-12">
    <p>
        {!! Form::label('is_verification_failed', 'Is Verification Failed:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_is_verification_failed">
        @if (isset($paymentDisbursement->is_verification_failed) && empty($paymentDisbursement->is_verification_failed)==false)
            {!! $paymentDisbursement->is_verification_failed !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Transaction Date Field -->
<div id="div_paymentDisbursement_transaction_date" class="col-lg-12">
    <p>
        {!! Form::label('transaction_date', 'Transaction Date:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_transaction_date">
        @if (isset($paymentDisbursement->transaction_date) && empty($paymentDisbursement->transaction_date)==false)
            {!! $paymentDisbursement->transaction_date !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Verified Amount Field -->
<div id="div_paymentDisbursement_verified_amount" class="col-lg-12">
    <p>
        {!! Form::label('verified_amount', 'Verified Amount:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_verified_amount">
        @if (isset($paymentDisbursement->verified_amount) && empty($paymentDisbursement->verified_amount)==false)
            {!! $paymentDisbursement->verified_amount !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Verification Meta Field -->
<div id="div_paymentDisbursement_verification_meta" class="col-lg-12">
    <p>
        {!! Form::label('verification_meta', 'Verification Meta:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_verification_meta">
        @if (isset($paymentDisbursement->verification_meta) && empty($paymentDisbursement->verification_meta)==false)
            {!! $paymentDisbursement->verification_meta !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>

<!-- Verification Notes Field -->
<div id="div_paymentDisbursement_verification_notes" class="col-lg-12">
    <p>
        {!! Form::label('verification_notes', 'Verification Notes:', ['class'=>'control-label']) !!} 
        <span id="spn_paymentDisbursement_verification_notes">
        @if (isset($paymentDisbursement->verification_notes) && empty($paymentDisbursement->verification_notes)==false)
            {!! $paymentDisbursement->verification_notes !!}
        @else
            N/A
        @endif
        </span>
    </p>
</div>


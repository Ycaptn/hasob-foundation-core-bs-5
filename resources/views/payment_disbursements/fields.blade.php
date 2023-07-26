<!-- Amount Field -->
<div id="div-amount" class="form-group">
    <label for="amount" class="col-lg-3 col-form-label">Amount</label>
    <div class="col-lg-9">
        {!! Form::text('amount', null, ['id'=>'amount', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Payable Type Field -->
<div id="div-payable_type" class="form-group">
    <label for="payable_type" class="col-lg-3 col-form-label">Payable Type</label>
    <div class="col-lg-9">
        {!! Form::text('payable_type', null, ['id'=>'payable_type', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Payable Id Field -->
<div id="div-payable_id" class="form-group">
    <label for="payable_id" class="col-lg-3 col-form-label">Payable Id</label>
    <div class="col-lg-9">
        {!! Form::text('payable_id', null, ['id'=>'payable_id', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Bank Account Number Field -->
<div id="div-bank_account_number" class="form-group">
    <label for="bank_account_number" class="col-lg-3 col-form-label">Bank Account Number</label>
    <div class="col-lg-9">
        {!! Form::text('bank_account_number', null, ['id'=>'bank_account_number', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Bank Name Field -->
<div id="div-bank_name" class="form-group">
    <label for="bank_name" class="col-lg-3 col-form-label">Bank Name</label>
    <div class="col-lg-9">
        {!! Form::text('bank_name', null, ['id'=>'bank_name', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Bank Sort Code Field -->
<div id="div-bank_sort_code" class="form-group">
    <label for="bank_sort_code" class="col-lg-3 col-form-label">Bank Sort Code</label>
    <div class="col-lg-9">
        {!! Form::text('bank_sort_code', null, ['id'=>'bank_sort_code', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Gateway Reference Code Field -->
<div id="div-gateway_reference_code" class="form-group">
    <label for="gateway_reference_code" class="col-lg-3 col-form-label">Gateway Reference Code</label>
    <div class="col-lg-9">
        {!! Form::text('gateway_reference_code', null, ['id'=>'gateway_reference_code', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Status Field -->
<div id="div-status" class="form-group">
    <label for="status" class="col-lg-3 col-form-label">Status</label>
    <div class="col-lg-9">
        {!! Form::text('status', null, ['id'=>'status', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Gateway Initialization Response Field -->
<div id="div-gateway_initialization_response" class="form-group">
    <label for="gateway_initialization_response" class="col-lg-3 col-form-label">Gateway Initialization Response</label>
    <div class="col-lg-9">
        {!! Form::text('gateway_initialization_response', null, ['id'=>'gateway_initialization_response', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Payment Instrument Type Field -->
<div id="div-payment_instrument_type" class="form-group">
    <label for="payment_instrument_type" class="col-lg-3 col-form-label">Payment Instrument Type</label>
    <div class="col-lg-9">
        {!! Form::text('payment_instrument_type', null, ['id'=>'payment_instrument_type', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Payment Instrument Type Field -->
<div id="div-payment_instrument_type" class="form-group">
    <label for="payment_instrument_type" class="col-lg-3 col-form-label">Payment Instrument Type</label>
    <div class="col-lg-9">
        {!! Form::text('payment_instrument_type', null, ['id'=>'payment_instrument_type', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Is Verified Field -->
<div id="div-is_verified" class="form-group">
    <label for="is_verified" class="col-lg-3 col-form-label">Is Verified</label>
    <div class="col-lg-9">
        {!! Form::radio('is_verified', "", null, ['id'=>'is_verified', 'class' => 'form-check-input']) !!}
        
    </div>
</div>

<!-- Is Verification Passed Field -->
<div id="div-is_verification_passed" class="form-group">
    <label for="is_verification_passed" class="col-lg-3 col-form-label">Is Verification Passed</label>
    <div class="col-lg-9">
        {!! Form::radio('is_verification_passed', "", null, ['id'=>'is_verification_passed', 'class' => 'form-check-input']) !!}
        
    </div>
</div>

<!-- Is Verification Failed Field -->
<div id="div-is_verification_failed" class="form-group">
    <label for="is_verification_failed" class="col-lg-3 col-form-label">Is Verification Failed</label>
    <div class="col-lg-9">
        {!! Form::radio('is_verification_failed', "", null, ['id'=>'is_verification_failed', 'class' => 'form-check-input']) !!}
        
    </div>
</div>

<!-- Start Transaction Date Field -->
<div id="div-transaction_date" class="form-group">
    <label for="transaction_date" class="col-lg-3 col-form-label">Transaction Date</label>
    <div class="col-lg-9">
        {!! Form::date('transaction_date', null, ['class' => 'form-control','id'=>'transaction_date']) !!}
    </div>
</div>
<!-- End Transaction Date Field -->

<!-- Verification Meta Field -->
<div id="div-verification_meta" class="form-group">
    <label for="verification_meta" class="col-lg-3 col-form-label">Verification Meta</label>
    <div class="col-lg-9">
        {!! Form::text('verification_meta', null, ['id'=>'verification_meta', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>

<!-- Verification Notes Field -->
<div id="div-verification_notes" class="form-group">
    <label for="verification_notes" class="col-lg-3 col-form-label">Verification Notes</label>
    <div class="col-lg-9">
        {!! Form::text('verification_notes', null, ['id'=>'verification_notes', 'class' => 'form-control','maxlength' => 200]) !!}
    </div>
</div>
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

<!-- Type Field -->
<div id="div-type" class="form-group">
    <label for="type" class="col-lg-3 col-form-label">Type</label>
    <div class="col-lg-9">
        {!! Form::text('type', null, ['id'=>'type', 'class' => 'form-control','maxlength' => 200]) !!}
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

<!-- Account Gateway Code Field -->
<div id="div-account_gateway_code" class="form-group">
    <label for="account_gateway_code" class="col-lg-3 col-form-label">Account Gateway Code</label>
    <div class="col-lg-9">
        {!! Form::text('account_gateway_code', null, ['id'=>'account_gateway_code', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Status Field -->
<div id="div-status" class="form-group">
    <label for="status" class="col-lg-3 col-form-label">Status</label>
    <div class="col-lg-9">
        {!! Form::text('status', null, ['id'=>'status', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>

<!-- Currency Field -->
<div id="div-currency" class="form-group">
    <label for="currency" class="col-lg-3 col-form-label">Currency</label>
    <div class="col-lg-9">
        {!! Form::text('currency', null, ['id'=>'currency', 'class' => 'form-control','minlength' => 2,'maxlength' => 100]) !!}
    </div>
</div>
<!-- Name Field -->
<div id="div-name" class="form-group">
    <label for="name" class="col-lg-3 col-form-label">Name</label>
    <div class="col-lg-9">
        {!! Form::text('name', null, ['id'=>'name', 'class' => 'form-control','minlength' => 4,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Status Field -->
<div id="div-status" class="form-group">
    <label for="status" class="col-lg-3 col-form-label">Status</label>
    <div class="col-lg-9">
        {!! Form::text('status', null, ['id'=>'status', 'class' => 'form-control','minlength' => 4,'maxlength' => 150]) !!}
    </div>
</div>

<!-- Start Closing Balance Amount Field -->
<div id="div-closing_balance_amount" class="row mb-3">
    <label for="closing_balance_amount" class="col-lg-3 col-form-label">Closing Balance Amount</label>
    <div class="col-sm-9">
        {!! Form::number('closing_balance_amount', null, ['id'=>'closing_balance_amount', 'class' => 'form-control','min' => 1,'max' => 1000000000000]) !!}
    </div>
</div>
<!-- End Closing Balance Amount Field -->

<!-- Is Reconciled Field -->
<div id="div-is_reconciled" class="form-group">
    <label for="is_reconciled" class="col-lg-3 col-form-label">Is Reconciled</label>
    <div class="col-lg-9">
        {!! Form::text('is_reconciled', null, ['id'=>'is_reconciled', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Start Date Field -->
<div id="div-start_date" class="form-group">
    <label for="start_date" class="col-lg-3 col-form-label">Start Date</label>
    <div class="col-lg-9">
        {!! Form::text('start_date', null, ['id'=>'start_date', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- End Date Field -->
<div id="div-end_date" class="form-group">
    <label for="end_date" class="col-lg-3 col-form-label">End Date</label>
    <div class="col-lg-9">
        {!! Form::text('end_date', null, ['id'=>'end_date', 'class' => 'form-control']) !!}
    </div>
</div>
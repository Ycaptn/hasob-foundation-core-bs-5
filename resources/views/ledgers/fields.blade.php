<!-- Name Field -->
<div id="div-name" class="form-group">
    <label class="control-label mb-10 col-sm-3" for="ledger_name">Name</label>
    <div class="col-sm-9">
        {!! Form::text('ledger_name',null,['id'=>'ledger_name','class'=>'form-control','maxlength'=>100,'maxlength'=>100]) !!}
    </div>
</div>



<div class="form-group">
    <label class="col-sm-3 mb-10 control-label">Department</label>
    <div class="col-sm-9">
        <div class="input-group">

            <select id="ledger_department" name="ledger_department" class="form-control">
                <option value="">Not Departmental Ledger</option>
                @if (isset($all_departments) && $all_departments != null)
                    @foreach ($all_departments as $idx=>$dept)
                        <option value="{{$dept->id}}">{{$dept->long_name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="input-group-addon"><span class="fa fa-institution"></span></span>

        </div>
    </div>
</div>
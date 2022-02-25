@extends('layouts.app')

@section('title_postfix')
Batch Details
@stop

@section('page_title')
Batch Details
@stop

@section('page_title_subtext')
    <a class="ml-10 mb-10" href="{{ route('gb.batches.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Batch List
    </a>
@stop

@section('page_title_buttons')
<span class="pull-right">
    <div class="pull-right inline-block dropdown mb-15">
        <a href="#" data-val='{{$batch->id}}' class='btn btn-xs btn-primary btn-edit-mdl-batch-modal'>
            <i class="icon wb-reply" aria-hidden="true"></i>Edit Batch
        </a>
    </div>
</span>
@stop

@section('content')
    <div class="panel panel-default card-view">
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div class="form-wrap">
                    <div class="row">
                        @include('hasob-scola-gradebook::pages.batches.show_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

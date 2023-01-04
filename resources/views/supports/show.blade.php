@extends('layouts.app')

@section('title_postfix')
    Support Details
@stop

@section('page_title')
    Support Details
@stop

@section('page_title_subtext')
    <a class="ms-10 mb-10" href="{{ route('fc.supportes.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to support List
    </a>
@stop

@section('page_title_buttons')
    <span class="float-end">
        <div class="float-end inline-block dropdown mb-15">
            <a href="#" data-val='{{ $support->id }}' class='btn btn-xs btn-primary btn-edit-mdl-support-modal'>
                <i class="icon wb-reply" aria-hidden="true"></i>Edit support
            </a>
        </div>
    </span>
@stop

@section('content')
    <div class="card">
        <div class="card-wrapper collapse in">
            <div class="card-body">
                <div class="form-wrap">
                    <div class="row">
                        @include(
                            'hasob-foundation-core::pages.supports.show_fields'
                        )
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

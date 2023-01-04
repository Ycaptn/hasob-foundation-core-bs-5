@extends('layouts.app')

@section('title_postfix')
    Annoucement Details
@stop

@section('page_title')
    Annoucement Details
@stop

@section('page_title_subtext')
    <a class="ms-10 mb-10" href="{{ route('fc.annoucementes.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Annoucement List
    </a>
@stop

@section('page_title_buttons')
    <span class="float-end">
        <div class="float-end inline-block dropdown mb-15">
            <a href="#" data-val='{{ $annoucement->id }}' class='btn btn-xs btn-primary btn-edit-mdl-annoucement-modal'>
                <i class="icon wb-reply" aria-hidden="true"></i>Edit annoucement
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
                            'hasob-foundation-core::pages.annoucements.show_fields'
                        )
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

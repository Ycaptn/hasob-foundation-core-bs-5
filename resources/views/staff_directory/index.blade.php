@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Staff Directory
@stop

@section('page_title')
Staff
@stop

@section('page_title_suffix')
Directory
@stop


@section('page_title_subtext')
    <a class="ms-1" href="{{ route('dashboard') }}">
        <i class="bx bx-chevron-left"></i> Back to Dashboard
    </a> 
@stop



@section('content')
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            {{ $cdv_deparment_staffs->render() }}
        </div>
    </div>
@stop


@push('page_scripts')
    {!! $cdv_deparment_staffs->render_js() !!}
@endpush


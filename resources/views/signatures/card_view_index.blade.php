@extends('layouts.app')

@section('app_css')
    {!! $cdv_signatures->render_css() !!}
@endsection

@section('title_postfix')
User Signatures
@stop

@section('page_title')
User
@stop

@section('page_title_suffix')
Signatures
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
@stop


@section('content')

    <div class="row">
        <div class="card border-top border-0 border-4 border-primary">
            <div class="card-body">
                {{ $cdv_signatures->render() }} 
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    {!! $cdv_signatures->render_js() !!}
@endpush
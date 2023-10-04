@extends(config('hasob-foundation-core.view_layout'))

@section('title_postfix')
API Tokens
@stop

@section('page_title')
API Tokens
@stop

@section('page_title_suffix')
API Tokens
@stop

@section('app_css')
    @include('layouts.datatables_css')
@stop

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('dashboard') }}">
        <i class="bx bx-chevron-left"></i> Back to Dashboard
    </a> 
@stop

@section('page_title_buttons')
    <a href="#" class="btn btn-primary btn-sm" id="btn-new-api_tokens-modal">
        <i class="fa fa-plus"></i> New API Token
    </a>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered mt-3']) !!}
    </div>
</div>

@include('hasob-foundation-core::api_tokens.modal')
<style>

#dataTableBuilder_filter{
    float: right;
    padding-bottom: 15px
}

#dataTableBuilder_processing{
    float: left;
    width: 100%;
    padding: 3px;
}
</style>

@stop


@push('page_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        $(document).ready(function() {
           
            $('.buttons-csv').hide();
            $('.buttons-pdf').hide();
            $('.buttons-excel').hide();
        });
    </script>    

@endpush
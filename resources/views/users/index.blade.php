@extends(config('hasob-foundation-core.view_layout'))

@php
$hide_right_panel = true;
@endphp

@section('title_postfix')
System Users
@stop

@section('page_title')
System
@stop

@section('page_title_suffix')
Users
@stop

@section('app_css')
    @include('layouts.datatables_css')
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
<a href="{{ route('fc.user.show', 0) }}" class="btn btn-primary btn-sm pull-right">
    <i class="fa fa-plus"></i> Create User
</a>
@stop

@section('content')



<div class="card">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered mt-3']) !!}
    </div>
</div>

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
            $('.buttons-print').hide();
            $('.buttons-excel').hide();
        });
    </script>    

@endpush
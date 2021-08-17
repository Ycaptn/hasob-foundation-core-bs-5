@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
System Users
@stop

@section('page_title')
System Users
@stop

@section('app_css')
    @include('layouts.datatables_css')
@endsection

@section('content')

    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

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
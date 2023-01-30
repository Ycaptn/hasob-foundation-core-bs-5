@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Attachments
@stop

@section('page_title')
Attachments
@stop

@section('page_title_suffix')
Stats
@stop

@section('app_css')
@stop

@section('page_title_subtext')
    <a class="ms-1" href="{{ route('dashboard') }}">
        <i class="bx bx-chevron-left"></i> Back to Dashboard
    </a> 
@stop

@section('page_title_buttons')
    @if (Auth()->user()->hasAnyRole(['admin']))
    @endif
@stop


@section('content')
    
    <div class="card border-top border-0 border-4 border-success">
        <div class="card-body">

            <div class="row g-2">
                        
                <div class="col-md-4 col-sm-4">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Path Type</th>
                                <th scope="col">Count</th>
                            </tr>
                        </thead>
                        @php
                            $grand_total = 0;
                        @endphp                                
                        @foreach($path_type_group_count as $idx => $value)
                        <tr>
                            <td>{{ empty($value->path_type) ? "N/A" : $value->path_type}}</td>
                            <td>{{$value->total}}</td>
                        </tr>
                        @php
                            $grand_total += $value->total;
                        @endphp                                
                        @endforeach
                        <tr>
                            <td><b>Total</b></td>
                            <td><b>{{$grand_total}}</b></td>
                        </tr>                                
                    </table>
                </div>

                <div class="col-md-4 col-sm-4">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">File Type</th>
                                <th scope="col">Count</th>
                            </tr>
                        </thead>
                        @php
                            $grand_total = 0;
                        @endphp
                        @foreach($file_type_group_count as $idx => $value)
                        <tr>
                            <td>{{ empty($value->file_type) ? "N/A" : $value->file_type}}</td>
                            <td>{{$value->total}}</td>
                        </tr>
                        @php
                            $grand_total += $value->total;
                        @endphp                                
                        @endforeach
                        <tr>
                            <td><b>Total</b></td>
                            <td><b>{{$grand_total}}</b></td>
                        </tr>                                
                    </table>
                </div>

                <div class="col-md-4 col-sm-4">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Storage Driver</th>
                                <th scope="col">Count</th>
                            </tr>
                        </thead>
                        @php
                            $grand_total = 0;
                        @endphp
                        @foreach($storage_driver_group_count as $idx => $value)
                        <tr>
                            <td>{{ empty($value->storage_driver) ? "N/A" : $value->storage_driver}}</td>
                            <td>{{$value->total}}</td>
                        </tr>
                        @php
                            $grand_total += $value->total;
                        @endphp
                        @endforeach
                        <tr>
                            <td><b>Total</b></td>
                            <td><b>{{$grand_total}}</b></td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>
    </div>

@stop


@push('page_scripts')
@endpush


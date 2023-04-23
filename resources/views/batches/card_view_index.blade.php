@extends('layouts.app')

@section('app_css')
    {!! $cdv_batches->render_css() !!}
@endsection

@section('title_postfix')
Batches
@stop

@section('page_title')
Batches
@stop

@section('page_title_suffix')
All
@stop

@section('page_title_buttons')
<span class="float-end">
    <a id="btn-new-mdl-batch-modal" class="btn btn-sm btn-primary btn-new-mdl-batch-modal" href="#">
        <i class="zmdi zmdi-file-plus"></i> Crete New Batch
    </a>
</span>
@stop

@section('content')
    <div class="row">
        <div class="card border-top border-0 border-4 border-success">
            <div class="card-body">
                    {{ $cdv_batches->render() }}
            </div>
        </div>
    </div>

    @include('hasob-foundation-core::batches.modal')
    
@endsection

@push('page_scripts')
    {!! $cdv_batches->render_js() !!}
@endpush
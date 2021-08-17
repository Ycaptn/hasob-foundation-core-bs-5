@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Ledgers
@stop

@section('page_title')
Ledgers
<a href="#" class="btn btn-xs btn-primary pull-right btn-new-mdl-ledger-modal">Create Ledger</a>
@stop

@section('app_css')
    
@endsection

@section('content')
    
    <x-hasob-foundation-core::ledgers-list :ledgers="$ledgers" />
    
@stop


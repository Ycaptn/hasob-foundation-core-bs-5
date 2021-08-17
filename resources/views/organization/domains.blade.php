@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Domains
@stop

@section('page_title')
Domains
<a href="#" class="btn btn-xs btn-primary pull-right btn-new-mdl-organization-modal">Add Domain</a>
@stop

@section('app_css')   
@endsection

@section('content')

<x-hasob-foundation-core::domain-list :domains="$domains" />

@stop

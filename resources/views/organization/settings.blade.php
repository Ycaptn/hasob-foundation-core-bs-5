@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Settings
@stop

@section('page_title')
Settings
<a href="#" class="btn btn-xs btn-primary pull-right btn-new-mdl-setting-modal">Add Setting</a>
@stop

@section('app_css')   
@endsection

@section('content')

    <x-hasob-foundation-core::settings-list :groups="$groups" :settings="$settings" />

@stop

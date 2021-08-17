@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Sites
@stop

@section('page_title')
Sites 
<a href="#" class="btn btn-xs btn-primary pull-right btn-new-mdl-site-modal">Create Site</a>
@stop

@section('app_css')    
@endsection

@section('content')


    <x-hasob-foundation-core::sites-list :sites="$sites" />
        

@stop

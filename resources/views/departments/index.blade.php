@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Departments
@stop

@section('page_title')
Departments
<a href="#" class="btn btn-xs btn-primary pull-right btn-new-mdl-department-modal">Add Department</a>
@stop

@section('app_css')   
@endsection

@section('content')
    
    <x-hasob-foundation-core::departments-list :departments="$departments" />

@stop

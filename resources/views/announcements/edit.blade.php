@extends('layouts.app')

@section('title_postfix')
Edit Announcement
@stop

@section('page_title')
Edit Announcement
@stop


@section('content')

        
    <div class="panel panel-default card-view">

        <div class="panel-wrapper collapse in">
            <div class="panel-body">

                <div class="col-sm-8">
                    <div class="form-wrap">
                        {!! Form::model($announcement, ['class'=>'form-horizontal', 'route' => ['announcements.update', $address->id], 'method' => 'patch']) !!}

                        @include('pages.announcements.fields')

                        <div class="col-sm-offset-3 col-sm-9">
                            <br/>
                            <hr class="light-grey-hr mb-10">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('announcements.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                        {!! Form::close() !!}                        
                    </div>
                </div>
                <div class="col-sm-4">
                    <blockquote class="muted" style="color:#9a9696;font-size:90%;border-left: 4px solid #c9c7f3;">
                        This is the help message <br/><br/>
                        This is the help message <br/><br/>
                        This is the help message <br/>
                    </blockquote>
                </div>

            </div>

        </div>
    </div>

@endsection

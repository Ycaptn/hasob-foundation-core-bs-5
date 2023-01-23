@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Application Features
@stop

@section('page_title')
Application
@stop

@section('page_title_suffix')
Features
@stop

@section('page_title_suffix')
Select enabled features on Platform
@stop

@section('app_css')   
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('dashboard') }}">
    <i class="bx bx-chevron-left"></i> Back to Dashboard
</a> 
@stop

@section('content')

<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body">

        <form method="POST" action="{{ route('fc.org-features-process') }}">
            @csrf
            <div class="row">
                @foreach ($features as $item=>$value)
                <div class="col-4 col-md-4 col-sm-4">
                    <div class="card shadow m-1">    
                        <div class="row p-3 g-0">
                            <div class="col-xs-12 col-md-9">
                                <span class="">{{ ucwords($item) }}</span>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div class="form-check">
                                    <input id="chk_{{$item}}" name="chk_{{$item}}" data-size="small" type="checkbox" class="js-switch form-check-input" value="1" {{$value?'checked':''}} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-sm mt-3 btn-primary">Save Feature Settings</button>
        </form>

    </div>
</div>


@push('page_scripts')
<script type="text/javascript">

    var switchery = {};
    $.fn.initComponents = function () {
        var searchBy = ".js-switch";
        $(this).find(searchBy).each(function (i, html) {
            if (!$(html).next().hasClass("switchery")) {
                switchery[html.getAttribute('id')] = new Switchery(html, $(html).data());
            }
        });
    };

    $(document).ready(function(){ 
        $("body").initComponents();
    });

</script>
@endpush


@stop

@extends(config('hasob-foundation-core.view_layout'))


@section('title_postfix')
Features
@stop

@section('page_title')
Features
@stop

@section('app_css')   
@endsection

@section('content')

<div class="row">

    <div class="col-lg-6">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-20">

                    <form method="POST" action="{{ route('fc.org-features-process') }}">
                        @csrf

                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach ($features as $item=>$value)
                                        <tr>
                                            <td class="pa-0 pl-10" width="40%">
                                                {{ ucwords($item) }}
                                            </td>
                                            <td class="pa-0" width="60%">
                                                <div class="form-group">
                                                    <input id="chk_{{$item}}" name="chk_{{$item}}" data-size="small" type="checkbox" class="js-switch" value="1" {{$value?'checked':''}} />
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-xs btn-primary">Save Feature Settings</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
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

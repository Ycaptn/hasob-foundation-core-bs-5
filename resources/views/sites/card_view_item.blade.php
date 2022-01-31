
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="panel panel-default card-view pa-0" style="border-radius:7px;">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 pa-10">

                                <div class="row">
                                    <div class="col-lg-2 txt-center">
                                        <a href="{{ route('fc.sites.show',$data_item->id) }}">
                                            <i style="font-size:500%;opacity:20%" class="zmdi zmdi-globe-alt txt-primary"></i>
                                        </a>
                                    </div>
                                    <div class="col-lg-10">
                                        <span class="panel-title">
                                            <a href="{{ route('fc.sites.show',$data_item->id) }}">{{ $data_item->site_name }}</a>
                                        </span>
                        
                                        <div class="pull-right">
                                            <a data-toggle="tooltip" 
                                                title="Edit" 
                                                data-val='{{$data_item->id}}' 
                                                class="btn-edit-mdl-site-modal inline-block mr-5" href="#">
                                                <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
                                            </a>

                                            <a data-toggle="tooltip" 
                                                title="Delete" 
                                                data-val='{{$data_item->id}}' 
                                                class="btn-delete-mdl-site-modal inline-block mr-5" href="#">
                                                <i class="zmdi zmdi-delete txt-danger" style="opacity:80%"></i>
                                            </a>
                                        </div>
            
                                        <span class="small">
                                            <br/>
                                            @if (empty($data_item->description) == false)
                                                {!! \Illuminate\Support\Str::limit($data_item->description,70,' ...') !!}
                                            @else
                                                No Description
                                            @endif
                                        </span>
            
                                        <span class="small">
                                            <br/>
                                            @php
                                            $site_id = empty($data_item->site_path) ? $data_item->id : $data_item->site_path;
                                            @endphp
                                            <a href="{{ route('fc.site-display.index',$site_id) }}">
                                            {!! \Illuminate\Support\Str::limit(route('fc.site-display.index',$site_id),40,' ...') !!}
                                            </a>
                                        </span>
            
                                    </div>
                                </div>

{{-- 
                                <div class="pull-left">
                                    <div class="pull-left user-img-wrap mr-15">
                                        <i class="fa fa-3x fa-globe mr-10"></i>
                                    </div>
                                    <div class="pull-left user-detail-wrap pt-5">	
                                        @php
                                            $detail_page_url = route('fc.sites.show', $data_item->id);
                                        @endphp
                                        <span class="block card-user-name">
                                            <a href='{{$detail_page_url}}'>{{$data_item->site_name}}</a><br/>
                                            <span class="small">
                                                @if (empty($data_item->description) == false)
                                                    {!! \Illuminate\Support\Str::limit($data_item->description,40,' ...') !!}
                                                @else
                                                    No Description
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="pull-right pt-5">
                                    <a data-toggle="tooltip" 
                                        title="Edit" 
                                        data-val='{{$data_item->id}}' 
                                        class="btn-edit-mdl-site-modal inline-block mr-5" href="#">
                                        <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
                                    </a>

                                    <a data-toggle="tooltip" 
                                        title="Delete" 
                                        data-val='{{$data_item->id}}' 
                                        class="btn-delete-mdl-site-modal inline-block mr-5" href="#">
                                        <i class="zmdi zmdi-delete txt-danger" style="opacity:80%"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div> 

--}}
                            </div>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
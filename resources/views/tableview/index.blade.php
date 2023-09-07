<div class="row mb-3">
    <div class="col-xs-12 col-md-8">
        @php
            $model_name = str_replace('\\','_',$query_model);
        @endphp
        @if ($filter_is_enabled == true)
        <a href="#" class="{{$control_id}}-{{$model_name}}-btn-filter btn btn-sm btn-primary btn-outline faded me-1">
            <i class="bx bx-filter-alt"></i> Filter
        </a>
        @endif
        
        @if(isset($can_add_data) &&  $can_add_data == true && isset($add_new_data_prop) && count($add_new_data_prop) > 0)
           <a href="{{isset($add_new_data_prop['link']) ?  $add_new_data_prop['link'] : '#'}}" id={{isset($add_new_data_prop['id']) ?  $add_new_data_prop['id'] : ''}} class="{{isset($add_new_data_prop['class']) ? $add_new_data_prop['class'] : 'btn btn-sm btn-primary'}}" style="{{isset($add_new_data_prop['style']) ? $add_new_data_prop['style'] : '' }}" > {{isset($add_new_data_prop['name']) ? $add_new_data_prop['name'] : 'Create' }}  </a>
        @endif

        @if (isset($action_buttons_list) && $action_buttons_list != null && count($action_buttons_list) > 0)
            @foreach ($action_buttons_list as $key => $account_button)
                @php
                    $button_icon = $account_button[0];
                    $button_href = $account_button[1];
                    $button_class = $account_button[2];
                    $button_data_map = $account_button[3];
                    $button_data_str = '';
                    if ($button_data_map != null && empty($button_data_map) == false && count($button_data_map) > 0) {
                        foreach ($button_data_map as $dkey => $dvalue) {
                            $button_data_str += " {$dkey}='{$dvalue}' ";
                        }
                    }
                @endphp
                <a href="{{ $button_href }}"
                    class="{{$control_id}}-{{$model_name}}-{{$model_name}}-btn btn btn-sm btn-primary btn-outline faded me-1 {{ $button_class }}"
                    {{ $button_data_str }}>
                    @if ($button_icon != null && empty($button_icon) == false)
                        <i class="{{ $button_icon }}"></i>
                    @endif
                    {{ $key }}
                </a>
            @endforeach
        @endif
        @if ($data_set_group_list != null && count($data_set_group_list) > 0)
            @foreach ($data_set_group_list as $key => $group)
                <button data-val="{{ $key }}"
                    class="{{$control_id}}-{{$model_name}}-grp btn btn-sm btn-primary btn-outline faded me-1">{{ $key }}</button>
            @endforeach
        @endif

        @if ($filter_is_enabled == true)
        <div class="row">
            <span id="txt-{{$control_id}}-{{$model_name}}-filter-settings" class="small text-danger" style="display:inline-block"></span>
        </div>
        @endif

    </div>
    <div class="col-xs-12 col-md-4">
        @if ($data_set_enable_search == true)
            <div class="input-group mb-3">
                <input type="text" id="{{$control_id}}-{{$model_name}}-txt-search" name="{{$control_id}}-{{$model_name}}-txt-search"
                    class="form-control form-control-sm" placeholder="{{ $search_placeholder_text }}">
                <span class="input-group-btn">
                    <button id="{{$control_id}}-{{$model_name}}-btn-search" name="{{$control_id}}-{{$model_name}}-btn-search" type="button"
                        class="h-100 btn btn-sm btn-primary btn-outline faded"><i class="fa fa-search d-inline"></i></button>
                </span>
            </div>
        @endif
    </div>
</div>

<div class="offline-flag"><span class="offline">You are currently offline</span></div>
<div id="spinner-{{$control_id}}-{{$model_name}}" class="row">
    <div class="loader" id="loader-{{$control_id}}-{{$model_name}}"></div>
</div>
<div class="table-responsive">
    <table class="table {{$table_bordered? 'table-bordered': '' }} {{$table_hover? 'table-hover': '' }} {{$table_striped? 'table-striped': '' }} {{$table_caption_top? 'caption-top': '' }}">
        <caption>{{$table_caption}}</caption>
        <thead>
            <tr>
                @foreach($table_headers as $th)
                    <th scope="col">{{$th}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="" id="{{$control_id}}-{{$model_name}}-div-table-view">
        
        </tbody>
    </table>
</div>



@if ($data_set_enable_pagination == true)
    <div class="row">
        <div class="col-xs-12">
            <ul id="{{$control_id}}-{{$model_name}}-pagination" class="pagination"></ul>
        </div>
    </div>
@endif

<div class="modal fade" id="mdl-{{$control_id}}-{{$model_name}}-filter-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-{{$control_id}}-{{$model_name}}-filter-modal-title" class="modal-title">Filter Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="frm-{{$control_id}}-{{$model_name}}-filter-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    @if ($filter_is_enabled==true && isset($filter_group_single_select) && count($filter_group_single_select)>0)
                        @foreach($filter_group_single_select as $filter_single_select_group=>$filter_single_select_options)
                            <div class="col-lg-12 mb-2">
                            {{ $filter_single_select_group }} <br/>
                            <select class="form-select" id="sel-filter-{{$control_id}}-{{$model_name}}-{{$filter_single_select_options[0]}}" name="sel-filter-{{$control_id}}-{{$model_name}}-{{$filter_single_select_options[0]}}">
                                <option value="null">All {{ $filter_single_select_group }}</option>
                                @foreach($filter_single_select_options[2] as $key=>$value)
                                <option value="{{$key}}">{{ucwords($value)}}</option>
                                @endforeach
                            </select>
                            </div>
                        @endforeach
                    @endif

                    @if ($filter_is_enabled==true && isset($filter_group_multiple_select) && count($filter_group_multiple_select)>0)
                        @foreach($filter_group_multiple_select as $filter_multiple_select_group=>$filter_multiple_select_options)
                        <div class="col-lg-12 mb-2">
                            {{ $filter_multiple_select_group }} <br/>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-2 ps-2">
                                @foreach($filter_multiple_select_options[2] as $key=>$value)
                                <div class="col">
                                    <input class="" type="checkbox"
                                            value="{{$key}}"
                                            id="cbx-filter-{{$control_id}}-{{$model_name}}-{{str_replace(",","",$filter_multiple_select_options[0])}}" 
                                            name="cbx-filter-{{$control_id}}-{{$model_name}}-{{str_replace(",","",$filter_multiple_select_options[0])}}"
                                    /> {{ucwords($value)}}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    @endif

                    @if ($filter_is_enabled==true && isset($filter_group_range_select) && count($filter_group_range_select)>0)
                        @foreach($filter_group_range_select as $filter_range_select_group=>$filter_range_select_options)
                        <div class="col-lg-12 mb-2">
                            {{ $filter_range_select_group }} {{$filter_range_select_options[1]}} <span id="lbl-rng-filter-{{$control_id}}-{{$model_name}}-{{str_replace(",","",$filter_range_select_options[0])}}"></span><br/>
                            <input type="range" class="form-range" value="0"
                                    min="{{$filter_range_select_options[2]}}" 
                                    max="{{$filter_range_select_options[3]}}" 
                                    data-val-is-entered = "0"
                                    id="rng-filter-{{$control_id}}-{{$model_name}}-{{str_replace(",","",$filter_range_select_options[0])}}"
                            />                        
                        </div>
                        @endforeach
                    @endif

                    @if ($filter_is_enabled==true && isset($filter_group_date_range_select) && count($filter_group_date_range_select)>0)
                        @foreach($filter_group_date_range_select as $filter_date_range_select_group=>$filter_date_range_select_options)
                        <div class="col-lg-12 mb-2">
                            {{ $filter_date_range_select_group }} <small class="text-primary"><i>(between date range)</i></small><br/>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input id="rng-start-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}" 
                                        class="form-control" 
                                        placeholder="Start Date" 
                                        type="date" 
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <input id="rng-end-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}" 
                                        class="form-control" 
                                        placeholder="End Date" 
                                        type="date" 
                                    />
                                </div>
                            </div>

                        </div>
                        @endforeach
                    @endif
                </form>
            </div>
        
            <div class="modal-footer" id="div-save-mdl-{{$control_id}}-{{$model_name}}-filter-modal">
                <button type="button" class="btn btn-warning float-left" id="btn-reset-mdl-{{$control_id}}-{{$model_name}}-filter-modal" value="add">Reset</button>
                <button type="button" class="btn btn-primary" id="btn-save-mdl-{{$control_id}}-{{$model_name}}-filter-modal" value="add">Apply</button>
            </div>

        </div>
    </div>
</div>

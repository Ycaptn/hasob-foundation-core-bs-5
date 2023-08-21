<?php

namespace Hasob\FoundationCore\View\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;


class TableDataView extends Component
{
    
    private $control_id;
    private $search_fields;
    private $relationship_key;
    private $relationship_search_fields;
    private $search_placeholder_text;
    public $query_relationship;

    private $table_bordered;
    private $table_caption;
    private $table_caption_top;
    private $table_headers;
    private $table_hover;
    private $table_striped;

    private $data_set_pagination_limit;
    private $data_set_enable_pagination;
    private $data_set_enable_search;
    
    private $data_item_template_path;
    private $data_set_group_list;
    private $data_set_query;

    private $filter_is_enabled;
    private $filter_group_range_select;
    private $filter_group_single_select;
    private $filter_group_multiple_select;
    private $filter_group_date_range_select;
    private $filter_related_fields;

    private $data_set_order_list;
    private $data_set_model;
    private $data_set_custom_order;

    private $add_new_data_prop;
    private $can_add_data;

    private $json_data_route_name;
    private $action_buttons_list;
    private $model_join_list;
    private $field_group_list;
    private $multiple_field_group_list;
    private $field_select_query;
    private $api_detail_page_url;
    private $template_data_collection;


    public function __construct($model, $template, Array $template_data_collection=null, $api_detail_page_url=null){

        $this->control_id = "tbv_".time();
        $this->data_set_pagination_limit = 20;
        $this->data_set_enable_pagination = true;
        $this->data_set_enable_search = false;
        $this->add_new_data_prop = [];
        $this->can_add_data = false;
        $this->data_item_template_path = $template;
        $this->data_set_model = $model;
        $this->api_detail_page_url = $api_detail_page_url;
        $this->template_data_collection = $template_data_collection;

        $this->filter_is_enabled = false;
        
        $this->table_headers = [];
        $this->table_caption = "";
        $this->table_caption_top = false;
        $this->table_hover = false;
        $this->table_striped = false;
        $this->table_bordered = false;

        return $this;
    }

    public function setJSONDataRouteName($route_name){
        $this->json_data_route_name = $route_name;
        return $this;
    }

    public function getJSONDataRouteName(){
        if (empty($this->json_data_route_name)==false){
            return $this->json_data_route_name;
        }
        return url()->full();
    }

    public function setDataItemTemplate($path){
        $this->data_item_template_path = $path;
        return $this;
    }

    public function setAddDataItemProps($values){
        $this->add_new_data_prop = $values;
        return $this;
    }

    public function setCanAddDataItem($value){
        $this->can_add_data = $value;
        return $this;
    }

    public function enableTableBorder(bool $enabled=true){
        $this->table_bordered = $enabled;
        return $this;
    }

    public function enableTableCaptionTop(bool $enabled=true){
        $this->table_caption_top = $enabled;
        return $this;
    }

    public function enableTableHover(bool $enabled=true){
        $this->table_hover = $enabled;
        return $this;
    }

    public function enableTableStripe(bool $enabled=true){
        $this->table_striped = $enabled;
        return $this;
    }

    public function setTableHeaders($headers){
        $this->table_headers = $headers;
        return $this;
    }

    public function setTableCaption($caption){
        $this->table_caption = $caption;
        return $this;
    }

    

    public function setSearchFields($fields){
        $this->search_fields = $fields;
        return $this;
    }
    

    public function setQueryRelationship($relationship){
        $this->query_relationship = $relationship;
        return $this;
    }

    public function setSearchRelationKey($relationship){
        $this->relationship_key = $relationship;
        return $this;
    }

    public function setSearchPlaceholder($text){
        $this->search_placeholder_text = $text;
        return $this;
    }

    public function enableSearch($enabled=true){
        $this->data_set_enable_search = $enabled;
        return $this;
    }

    public function enablePagination($enabled=true){
        $this->data_set_enable_pagination = $enabled;
        return $this;
    }

    public function setPaginationLimit($limit=20){
        $this->data_set_pagination_limit = $limit;
        return $this;
    }

    public function setDataQuery($query){
        $this->data_set_query = $query;
        return $this;
    }

    public function addActionButton($button_text, $button_icon=null, $button_href='#', $button_class=null, $button_data_map=null){
        if ($this->action_buttons_list == null){
            $this->action_buttons_list = array();
        }
        $this->action_buttons_list[$button_text] = [$button_icon, $button_href, $button_class, $button_data_map];
        return $this;
    }

    public function addModelJoin($joined_table, $left_field, $operation, $right_field){
        if ($this->model_join_list == null){
            $this->model_join_list = array();
        }
        $this->model_join_list[$joined_table] = [$left_field, $operation, $right_field];
        return $this;
    }

    public function addGroupField($group_field){
        if ($this->field_group_list == null){
            $this->field_group_list = array();
        }
        $this->field_group_list[] = $group_field;
        return $this;
    }

    public function addMultipleGroupField($group_fields){
        if($this->multiple_field_group_list == null){
            $this->multiple_field_group_list = array();
        }
        $this->multiple_field_group_list[] = $group_fields;
        return $this;
    }

    public function addSelectField($select_field){
        $this->field_select_query = $select_field;
        return $this;
    }

    public function addDataGroup($group_name, $query_field, $query_value, $query_operator='='){
        if ($this->data_set_group_list == null){
            $this->data_set_group_list = array();
        }
        $this->data_set_group_list[$group_name] = [$query_field, $query_operator, $query_value];
        return $this;
    }

    public function addDataOrder($order_field, $order_type){
        if ($this->data_set_order_list == null){
            $this->data_set_order_list = array();
        }
        $this->data_set_order_list[$order_field] = $order_type;
        return $this;
    }

    public function addCustomDataOrder($order_field, $order_data){
        if($this->data_set_custom_order == null){
            $this->data_set_custom_order = array();
        }
        $this->data_set_custom_order[$order_field] = $order_data;
        return $this;
    }

    public function enableFilter($setting=true){
        $this->filter_is_enabled = $setting;
        return $this;
    }

    public function addFilterRelatedFields($query_field, $query_data){
        if($this->filter_related_fields == null){
            $this->filter_related_fields = array();
        }
        $this->filter_related_fields[$query_field] = $query_data;
        return $this;
    }

    public function addFilterGroupRangeSelect($group_name, $query_field, $start_range, $end_range, $range_operator="="){
        if ($this->filter_group_range_select == null){
            $this->filter_group_range_select = array();
        }
        $this->filter_group_range_select[$group_name] = [$query_field, $range_operator, $start_range, $end_range];
        return $this;
    }

    public function addFilterGroupDateRangeSelect($group_name, $query_field){
        if ($this->filter_group_date_range_select == null){
            $this->filter_group_date_range_select = array();
        }
        $this->filter_group_date_range_select[$group_name] = [$query_field];
        return $this;
    }

    public function addFilterGroupSingleSelect($group_name, $query_field, $query_options, $query_operator='='){
        if ($this->filter_group_single_select == null){
            $this->filter_group_single_select = array();
        }
        $this->filter_group_single_select[$group_name] = [$query_field, $query_operator, $query_options];
        return $this;
    }

    public function addFilterGroupMultipleSelect($group_name, $query_field, $query_options, $query_operator='='){
        if ($this->filter_group_multiple_select == null){
            $this->filter_group_multiple_select = array();
        }
        $this->filter_group_multiple_select[$group_name] = [$query_field, $query_operator, $query_options];
        return $this;
    }

    public function render(){

        if (request()->expectsJson()){

            $search_term = null;
            if (request()->has('st')){
                $search_term = request()->input('st');
            }

            $model_query = new $this->data_set_model();

            if ($this->field_select_query != null){
                $model_query = $model_query->selectRaw($this->field_select_query);
            }

            if ($this->data_set_query!=null && is_array($this->data_set_query)){
                $model_query = $model_query->where($this->data_set_query);
            }

            if ($this->query_relationship!=null && is_array($this->query_relationship)){
                foreach ($this->query_relationship as $key => $fields) {
                    if(is_array($fields)){
                        $model_query =   $model_query->whereHas($key, function($q) use ($fields){
                            foreach($fields as $idx=>$value){
                                $q->where($idx,$value);
                            }
                        });
                    }
                }
            }

            if ($this->data_set_order_list != null && is_array($this->data_set_order_list)){
                foreach($this->data_set_order_list as $order_field=>$order_type){
                    $model_query = $model_query->orderBy($order_field, $order_type);
                }
            }

            if($this->data_set_custom_order !== null && is_array($this->data_set_custom_order)) {
                foreach($this->data_set_custom_order as $order_field=>$order_data) {
                    $model_query = $model_query->orderByRaw("FIELD($order_field, '" . implode("','", $order_data) . "')");
                }
            }

            if ($this->model_join_list != null && is_array($this->model_join_list)){
                foreach($this->model_join_list as $join_table=>$join_parameters){
                    $model_query = $model_query->join($join_table, $join_parameters[0], $join_parameters[1], $join_parameters[2]);
                }
            }

            if ($this->field_group_list != null && is_array($this->field_group_list)){
                $model_query = $model_query->groupBy(implode(",", $this->field_group_list));
            }

            
            if ($this->multiple_field_group_list != null && is_array($this->multiple_field_group_list)){
                foreach($this->multiple_field_group_list as $group_fields)
                    $model_query = $model_query->groupBy($group_fields);
            }

            if (empty($search_term)==false && $this->search_fields!=null && is_array($this->search_fields)){
                
                $search_fields = $this->search_fields;
                $relationship = $this->relationship_key;
                if(is_array($relationship)){
                    foreach ($relationship as $key => $fields) {
                      if(is_array($fields)){
                        $model_query->whereHas($key ,function($q) use ($fields,$search_term){
                            foreach($fields as $idx=>$search_field){
                                if($idx == 0){
                                    $q->where($search_field,'LIKE',"%{$search_term}%");   
                                }else{
                                    $q->orWhere($search_field,'LIKE',"%{$search_term}%");
                                }       
                            }
                        })->orWhere(function($q) use ($search_fields, $search_term){
                                foreach($search_fields as $idx=>$search_field){
                                    $q->orWhere($search_field,"LIKE","%{$search_term}%");
                            }
                        });
                      }
                    }   
                } else{
                        $model_query->where(function($q) use ($search_fields, $search_term){
                            foreach($search_fields as $idx=>$search_field){
                                $q->orWhere($search_field,"LIKE","%{$search_term}%");
                            }
                        });
                }
            }

            if($this->filter_related_fields!==null && is_array($this->filter_related_fields)){
                foreach($this->filter_related_fields as $query_field=>$query_data) {
                    $model_query = $model_query->whereIn($query_field,$query_data);
                }
            }
            
            $group_term = null;
            if (request()->has('grp')){
                $group_term = request()->input('grp');
            }
            if (empty($group_term)==false 
                && $this->data_set_group_list!=null 
                && is_array($this->data_set_group_list)
                && isset($this->data_set_group_list[$group_term])
                && count($this->data_set_group_list[$group_term])==3){
                
                $model_query = $model_query->where(
                    $this->data_set_group_list[$group_term][0],
                    $this->data_set_group_list[$group_term][1],
                    $this->data_set_group_list[$group_term][2]
                );
            }

            if ($this->filter_is_enabled && isset($this->filter_group_single_select) && count($this->filter_group_single_select)>0){
                foreach($this->filter_group_single_select as $filter_single_select_group=>$filter_single_select_options){
                    if (request()->has($filter_single_select_options[0]) && 
                        !empty(request()->input($filter_single_select_options[0])) &&
                        request()->input($filter_single_select_options[0]) != "null" &&
                        request()->input($filter_single_select_options[0]) != "undefined"){

                        $filter_single_select_fields = explode(",",$filter_single_select_options[0]);
                        $fieldValue = request()->input($filter_single_select_options[0]);
                        $fieldOperator = $filter_single_select_options[1];

                        foreach($filter_single_select_fields as $fieldIdx=>$fieldName){
                            $model_query = $model_query->where($fieldName,$fieldOperator,$fieldValue);
                        }
                    }
                }
            }

            if ($this->filter_is_enabled && isset($this->filter_group_multiple_select) && count($this->filter_group_multiple_select)>0){
                foreach($this->filter_group_multiple_select as $filter_multiple_select_group=>$filter_multiple_select_options){
                    if (request()->has($filter_multiple_select_options[0]) && 
                        !empty(request()->input($filter_multiple_select_options[0])) &&
                        request()->input($filter_multiple_select_options[0]) != "null" &&
                        request()->input($filter_multiple_select_options[0]) != "undefined" ){

                        $filter_multiple_select_fields = explode(",",$filter_multiple_select_options[0]);
                        $filter_multiple_select_values = explode(",",request()->input($filter_multiple_select_options[0]));

                        $model_query = $model_query->where(function($query) use ($filter_multiple_select_fields, $filter_multiple_select_values) {
                            foreach($filter_multiple_select_fields as $fieldIdx=>$fieldName){
                                $query->whereIn($fieldName, $filter_multiple_select_values,"or");
                        }});
                        
                    }
                }
            }

            if ($this->filter_is_enabled && isset($this->filter_group_range_select) && count($this->filter_group_range_select)>0){
                foreach($this->filter_group_range_select as $filter_range_select_group=>$filter_range_select_options){
                    if (request()->has($filter_range_select_options[0]) && 
                        !empty(request()->input($filter_range_select_options[0])) &&
                        request()->input($filter_range_select_options[0]) != "null" &&
                        request()->input($filter_range_select_options[0]) != "undefined"){

                        $filter_range_select_fields = explode(",",$filter_range_select_options[0]);
                        $fieldValue = request()->input($filter_range_select_options[0]);
                        $fieldOperator = $filter_range_select_options[1];

                        foreach($filter_range_select_fields as $fieldIdx=>$fieldName){
                            $model_query = $model_query->where($fieldName,$fieldOperator,$fieldValue);
                        }
                    }
                }
            }

            if ($this->filter_is_enabled && isset($this->filter_group_date_range_select) && count($this->filter_group_date_range_select)>0){
                foreach($this->filter_group_date_range_select as $filter_date_range_select_group=>$filter_date_range_select_options){
                    if (request()->has($filter_date_range_select_options[0]."-start") && 
                        !empty(request()->input($filter_date_range_select_options[0]."-start")) &&
                        request()->input($filter_date_range_select_options[0]."-start") != "null" &&
                        request()->input($filter_date_range_select_options[0]."-start") != "undefined"){

                        $filter_date_range_select_fields = explode(",",$filter_date_range_select_options[0]);
                        $fieldValueStart = request()->input($filter_date_range_select_options[0]."-start");

                        foreach($filter_date_range_select_options as $fieldIdx=>$fieldName){
                            $model_query = $model_query->where($fieldName,">=",$fieldValueStart);
                        }
                    }

                    if (request()->has($filter_date_range_select_options[0]."-end") && 
                        !empty(request()->input($filter_date_range_select_options[0]."-end")) &&
                        request()->input($filter_date_range_select_options[0]."-end") != "null" &&
                        request()->input($filter_date_range_select_options[0]."-end") != "undefined"){

                        $filter_date_range_select_fields = explode(",",$filter_date_range_select_options[0]);
                        $fieldValueEnd = request()->input($filter_date_range_select_options[0]."-end");

                        foreach($filter_date_range_select_options as $fieldIdx=>$fieldName){
                            $model_query = $model_query->where($fieldName,"<=",$fieldValueEnd);
                        }
                    }
                }
            }

            $results = [];
            $results_count = 0;
            $selected_page = 1;
            
            if ($this->data_set_enable_pagination == true){

                $selected_page = 1;
                if (request()->has('pg')){
                    $selected_page = request()->input('pg');
                }

                $results = $model_query->paginate($this->data_set_pagination_limit,['*'],'page',$selected_page);
                $results_count = $results->total();

            } else {
                $results = $model_query->get();
                $results_count = count($results);
            }

            $table_html = "";
            foreach($results as $index => $data_item){
                $table_html .= view($this->data_item_template_path)
                    ->with('index', $index+1)
                    ->with('data_item', $data_item)
                    ->with('data_collection', $this->template_data_collection)
                    ->with('api_detail_page_url', $this->api_detail_page_url);
            }

            return response()->json([
                "paginate" => $this->data_set_enable_pagination,
                "page_number" => $selected_page,
                "pages_total" => intval(ceil($results_count/$this->data_set_pagination_limit)),
                "search_term" => $search_term,
                "result_count" => $results_count,
                "control_id" => $this->control_id,
                "tables_html" => $table_html,
                "page_limit" => $this->data_set_pagination_limit,
            ]);
        }

        return view('hasob-foundation-core::tableview.index')
                    ->with('control_obj',$this)
                    ->with('query_model',$this->data_set_model)
                    ->with('control_id',$this->control_id)
                    ->with('table_headers',$this->table_headers)
                    ->with('table_caption',$this->table_caption)
                    ->with('table_caption_top',$this->table_caption_top)
                    ->with('table_hover', $this->table_hover)
                    ->with('table_striped', $this->table_striped)
                    ->with('table_bordered', $this->table_bordered)
                    ->with('data_set_query',$this->data_set_query)
                    ->with('action_buttons_list',$this->action_buttons_list)
                    ->with('data_set_group_list',$this->data_set_group_list)
                    ->with('data_set_pagination_limit',$this->data_set_pagination_limit)
                    ->with('data_set_enable_pagination',$this->data_set_enable_pagination)
                    ->with('data_set_enable_search',$this->data_set_enable_search)
                    ->with('data_set_custom_order',$this->data_set_custom_order)
                    ->with('search_placeholder_text',$this->search_placeholder_text)
                    ->with('filter_is_enabled',$this->filter_is_enabled)
                    ->with('add_new_data_prop',$this->add_new_data_prop)
                    ->with('can_add_data',$this->can_add_data)
                    ->with('multiple_field_group_list',$this->multiple_field_group_list)
                    ->with('filter_group_single_select',$this->filter_group_single_select)
                    ->with('filter_group_multiple_select',$this->filter_group_multiple_select)
                    ->with('filter_group_range_select',$this->filter_group_range_select)
                    ->with('filter_related_fields',$this->filter_related_fields)
                    ->with('filter_group_date_range_select',$this->filter_group_date_range_select);

    }

    public function render_css(){
        return view("hasob-foundation-core::tableview.table-view-css")
                    ->with('control_id',$this->control_id)
                    ->with('query_model',$this->data_set_model)
                    ->with('data_set_query',$this->data_set_query)
                    ->with('data_set_group_list',$this->data_set_group_list)
                    ->with('action_buttons_list',$this->action_buttons_list)
                    ->with('data_set_pagination_limit',$this->data_set_pagination_limit)
                    ->with('data_set_enable_pagination',$this->data_set_enable_pagination)
                    ->with('data_set_enable_search',$this->data_set_enable_search)
                    ->with('search_placeholder_text',$this->search_placeholder_text);
    }

    public function render_js(){
        return view("hasob-foundation-core::tableview.table-view-js")
                    ->with('control_obj',$this)
                    ->with('control_id',$this->control_id)
                    ->with('query_model',$this->data_set_model)
                    ->with('data_set_query',$this->data_set_query)
                    ->with('data_set_group_list',$this->data_set_group_list)
                    ->with('data_set_custom_order',$this->data_set_custom_order)
                    ->with('multiple_field_group_list',$this->multiple_field_group_list)
                    ->with('action_buttons_list',$this->action_buttons_list)
                    ->with('data_set_pagination_limit',$this->data_set_pagination_limit)
                    ->with('data_set_enable_pagination',$this->data_set_enable_pagination)
                    ->with('data_set_enable_search',$this->data_set_enable_search)
                    ->with('search_placeholder_text',$this->search_placeholder_text)
                    ->with('filter_is_enabled',$this->filter_is_enabled)
                    ->with('filter_group_single_select',$this->filter_group_single_select)
                    ->with('filter_group_multiple_select',$this->filter_group_multiple_select)
                    ->with('filter_group_range_select',$this->filter_group_range_select)
                    ->with('filter_related_fields',$this->filter_related_fields)
                    ->with('filter_group_date_range_select',$this->filter_group_date_range_select);
    }

}
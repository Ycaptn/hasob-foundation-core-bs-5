

<script type="text/javascript">
    $(document).ready(function() {
        let page_total = 0;
        let current_page = 0;
        let filter_by_group_term = null;

        {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+"?query_model={{$query_model}}");


        //get page list 
        function getPageList(totalPages, page, maxLength) {
            if (maxLength < 5) throw "maxLength must be at least 5";

            function range(start, end) {
                return Array.from(Array(end - start + 1), (_, i) => i + start); 
            }

            let sideWidth = maxLength < 9 ? 1 : 2;
            let leftWidth = (maxLength - sideWidth*2 - 3) >> 1;
            let rightWidth = (maxLength - sideWidth*2 - 2) >> 1;
            if (totalPages <= maxLength) {
                // no breaks in list
                return range(1, totalPages);
            }
            if (page <= maxLength - sideWidth - 1 - rightWidth) {
                // no break on left of page
                return range(1, maxLength - sideWidth - 1)
                    .concat(0, range(totalPages - sideWidth + 1, totalPages));
            }
            if (page >= totalPages - sideWidth - 1 - rightWidth) {
                // no break on right of page
                return range(1, sideWidth)
                    .concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }
            // Breaks on both sides
            return range(1, sideWidth)
                .concat(0, range(page - leftWidth, page + rightWidth),
                        0, range(totalPages - sideWidth + 1, totalPages));
        }

        //show page
        function showPage(whichPage,totalPages,paginationSize) {
            if (whichPage < 1 || whichPage > totalPages) return false;
            let currentPage = whichPage;

                // Include the prev button
            $("#{{$control_id}}-pagination").prepend(
                    $("<li>").addClass("page-item").attr({ id: "previous-page" }).append(
                    $("<a>").addClass("page-link {{$control_id}}-pg").attr({
                    href: "javascript:void(0)"}).text("Prev").attr('data-type','pre')
                )
            )
            getPageList(totalPages, currentPage, paginationSize).forEach( item => {
                $("#{{$control_id}}-pagination").append(
                    `<li class="page-item">
                        <a 
                            data-val='${item === 0 ? currentPage : item}'
                            data-type='pg' 
                            class='{{$control_id}}-pg pg-${item} page-link' ${item ? "currentPage" : "disabled"}'
                            href =' javascript:void(0)'
                        >
                            ${item || "..."}
                        </a>
                    </li>
                    `);
                    (currentPage == item) ? $('.pg-'+item).addClass('cdv-current-page').addClass("active").addClass("bg-primary text-white") : $('.pg-'+item).addClass('text-primary');
            })
                        
                        
                        
            // include next button:
            $("#{{$control_id}}-pagination").append(
                $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
                $("<a>").addClass("page-link").addClass("{{$control_id}}-pg").attr({
                    href: "javascript:void(0)"}).text("Next").attr('data-type','nxt')
                )
            ); 
            // Disable prev/next when at first/last page:
            $("#previous-page").toggleClass("disabled", currentPage === 1);                
            $("#next-page").toggleClass("disabled", currentPage === totalPages);            
                                    
        }

        function {{$control_id}}_display_results(endpoint_url){
            $.ajaxSetup({
                cache: false, 
                headers: {'X-CSRF-TOKEN':"{{ csrf_token() }}"}
            });

            let join_string = "?";
            let final_endpoint_url = endpoint_url;

            @if ($filter_is_enabled && isset($filter_group_single_select) && count($filter_group_single_select)>0)
                @foreach($filter_group_single_select as $filter_single_select_group=>$filter_single_select_options)
                    if (final_endpoint_url.includes("?")){ join_string = "&"; }

                    var singleFieldName = "{{$filter_single_select_options[0]}}";
                    var singleFieldValue = $("#sel-filter-{{$control_id}}-{{$filter_single_select_options[0]}}").val();
                    final_endpoint_url += join_string + singleFieldName + "="+ singleFieldValue;
                @endforeach
            @endif


            @if ($filter_is_enabled && isset($filter_group_multiple_select) && count($filter_group_multiple_select)>0)
                @foreach($filter_group_multiple_select as $filter_multiple_select_group=>$filter_multiple_select_options)
                    if (final_endpoint_url.includes("?")){ join_string = "&"; }

                    var multiFieldName = "{{$filter_multiple_select_options[0]}}";
                    var multiFieldValues = $("#cbx-filter-{{$control_id}}-{{str_replace(',','',$filter_multiple_select_options[0])}}:checked").map(function(){
                        return $(this).val();
                    });
                    if (multiFieldValues && multiFieldValues.length>0){
                        final_endpoint_url += join_string + multiFieldName +"="+ multiFieldValues.toArray().toString();
                    }
                @endforeach
            @endif

            @if ($filter_is_enabled && isset($filter_group_range_select) && count($filter_group_range_select)>0)
                @foreach($filter_group_range_select as $filter_range_select_group=>$filter_range_select_options)
                    if (final_endpoint_url.includes("?")){ join_string = "&"; }

                    var rangeFieldName = "{{$filter_range_select_options[0]}}";
                    var rangeFieldValue = $("#rng-filter-{{ $control_id }}-{{str_replace(",","",$filter_range_select_options[0])}}").val();
                    var rangeFieldValueIsEntered = $("#rng-filter-{{ $control_id }}-{{str_replace(",","",$filter_range_select_options[0])}}").attr("data-val-is-entered");
                    if (rangeFieldValueIsEntered && rangeFieldValueIsEntered=="1" && rangeFieldValue && rangeFieldValue != null && rangeFieldValue>0){
                        final_endpoint_url += join_string + rangeFieldName +"="+ rangeFieldValue;
                    }
                @endforeach
            @endif

            @if ($filter_is_enabled && isset($filter_group_date_range_select) && count($filter_group_date_range_select)>0)
                @foreach($filter_group_date_range_select as $filter_date_range_select_group=>$filter_date_range_select_options)
                    if (final_endpoint_url.includes("?")){ join_string = "&"; }

                    var rangeFieldName = "{{$filter_date_range_select_options[0]}}";
                    var rangeFieldStartValue = $("#rng-start-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}").val();
                    var rangeFieldEndValue = $("#rng-end-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}").val();

                    if (rangeFieldStartValue != null && rangeFieldStartValue.length>0 && rangeFieldStartValue != "undefined"){
                        final_endpoint_url += join_string + rangeFieldName +"-start="+ rangeFieldStartValue;
                    }
                    if (rangeFieldEndValue != null && rangeFieldEndValue.length>0 && rangeFieldEndValue != "undefined"){
                        final_endpoint_url += join_string + rangeFieldName +"-end="+ rangeFieldEndValue;
                    }
                @endforeach
            @endif

            //check for internet status 
            if (!window.navigator.onLine) {
                $('.offline').fadeIn(300);
                return;
            }else{
                $('.offline').fadeOut(300);
            }

            $("#spinner-{{$control_id}}").show();
            $('#{{$control_id}}-div-card-view').empty();
            $('#{{$control_id}}-div-card-view').append("<span class='text-center m-4 p-4'>Loading.....</span>");
           
            $.get(final_endpoint_url).done(function( response ) {
                current_page = parseInt(response.page_number);
                page_total = parseInt(response.pages_total);
               
            
                if (response != null && response.cards_html != null){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append(response.cards_html);
                }
                if (response != null && response.result_count==0){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append("<span class='text-center ma-20 pa-20' style='padding-bottom:100px'>No results found.</span>");
                }
                $("#{{$control_id}}-pagination").empty();
                if (response != null && response.paginate && response.result_count > 0){
                    $(".pagination li").slice(1, -1).remove();
                    showPage(current_page, page_total,7)

                  
                    $("#{{$control_id}}-pagination").show();
                }
                $("#spinner-{{$control_id}}").hide();
            });
        }

        $(document).on('keyup', "#{{$control_id}}-txt-search", function(e) {
            e.preventDefault();
            let search_term = $('#{{$control_id}}-txt-search').val();
            let search_term_query = "?st="+search_term;
            @if(!empty(request()->query()) && count(request()->query()) > 0)
                search_term_query = "&st="+search_term;
            @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+search_term_query+"&query_model={{$query_model}}");
        });

        $(document).on('click', "#{{$control_id}}-btn-search", function(e) {
            e.preventDefault();
            let search_term = $('#{{$control_id}}-txt-search').val();
            let search_term_query = "?st="+search_term;
            @if(!empty(request()->query()) && count(request()->query()) > 0)
                search_term_query = "&st="+page_number;
            @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+search_term_query+"&query_model={{$query_model}}");
        });

        $(document).on('click', ".{{$control_id}}-grp", function(e) {
            e.preventDefault();
            let group_term = $(this).attr('data-val');
            filter_by_group_term = group_term;
            $("#{{$control_id}}-pagination").hide();
            let group_term_query = "?grp="+group_term;
            @if(!empty(request()->query()) && count(request()->query()) > 0)
                group_term_query = "&grp="+group_term;
            @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+group_term_query+"&query_model={{$query_model}}");
            
        });

        //next and previous button listener
        $(document).on('click', ".{{$control_id}}-pg", function(e) {
            e.preventDefault();

            let page_number = 1;
            
            $("#{{$control_id}}-pagination").hide();
            if($(this).attr('data-type') == 'pg'){
                page_number = $(this).attr('data-val');
            } else if($(this).attr('data-type') == '#'){
                console.log(" For null")
            }
            if($(this).attr('data-type') == 'pre'){
               page_number = parseInt(current_page) - 1;
            }
            if($(this).attr('data-type') == 'nxt'){
                page_number = parseInt(current_page) + 1;
            }
           let pg_query = "?pg="+page_number;
           if(filter_by_group_term!=null) {
                pg_query += "&grp="+filter_by_group_term; 
           }
           @if(!empty(request()->query()) && count(request()->query()) > 0)
                pg_query = "&pg="+page_number;
           @endif
    
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+pg_query+"&query_model={{$query_model}}");
            
        });

        $(document).on('click', ".{{ $control_id }}-btn-filter", function(e) {            
            $('#mdl-{{ $control_id }}-filter-modal').modal('show');
        });

        $(document).on('click', "#btn-save-mdl-{{ $control_id }}-filter-modal", function(e) {
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}");
            $('#mdl-{{ $control_id }}-filter-modal').modal('hide');

            var filter_settings_string = "<b>Filter</b>";
            @if ($filter_is_enabled && isset($filter_group_single_select) && count($filter_group_single_select)>0)
                @foreach($filter_group_single_select as $filter_single_select_group=>$filter_single_select_options)
                    var singleFieldValue = $("#sel-filter-{{$control_id}}-{{$filter_single_select_options[0]}} option:selected").text();
                    if (singleFieldValue && singleFieldValue.length>0 && singleFieldValue!="null" && singleFieldValue!="undefined"){
                        filter_settings_string += " - " + singleFieldValue;
                    }
                @endforeach
            @endif

            @if ($filter_is_enabled && isset($filter_group_multiple_select) && count($filter_group_multiple_select)>0)
                @foreach($filter_group_multiple_select as $filter_multiple_select_group=>$filter_multiple_select_options)
                    var multiFieldValues = $("#cbx-filter-{{$control_id}}-{{str_replace(',','',$filter_multiple_select_options[0])}}:checked").map(function(){
                        return $(this).val();
                    });
                    if (multiFieldValues && multiFieldValues.length>0){
                        filter_settings_string += " - " + multiFieldValues.toArray().toString();
                    }
                @endforeach
            @endif

            @if ($filter_is_enabled && isset($filter_group_range_select) && count($filter_group_range_select)>0)
                @foreach($filter_group_range_select as $filter_range_select_group=>$filter_range_select_options)
                    var range_value = new Intl.NumberFormat().format($("#rng-filter-{{ $control_id }}-{{str_replace(",","",$filter_range_select_options[0])}}").val());
                    var rangeFieldValueIsEntered = $("#rng-filter-{{$control_id}}-{{str_replace(",","",$filter_range_select_options[0])}}").attr("data-val-is-entered");
                    if (rangeFieldValueIsEntered == "1"){
                        filter_settings_string += " - " + "{{$filter_range_select_group}} {{$filter_range_select_options[1]}} " + range_value;
                    }
                @endforeach
            @endif

            @if ($filter_is_enabled && isset($filter_group_date_range_select) && count($filter_group_date_range_select)>0)
                @foreach($filter_group_date_range_select as $filter_date_range_select_group=>$filter_date_range_select_options)                
                    var rangeFieldName = "{{$filter_date_range_select_options[0]}}";
                    var rangeFieldStartValue = $("#rng-start-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}").val();
                    var rangeFieldEndValue = $("#rng-end-date-filter-{{$control_id}}-{{str_replace(",","",$filter_date_range_select_options[0])}}").val();

                    if (rangeFieldStartValue != null && rangeFieldStartValue.length>0 && rangeFieldStartValue != "undefined" && rangeFieldEndValue != null && rangeFieldEndValue.length>0 && rangeFieldEndValue != "undefined"){
                        filter_settings_string += " - {{$filter_date_range_select_group}}";
                    }
                    if (rangeFieldStartValue != null && rangeFieldStartValue.length>0 && rangeFieldStartValue != "undefined"){
                        filter_settings_string += " from " + rangeFieldStartValue;
                    }
                    if (rangeFieldEndValue != null && rangeFieldEndValue.length>0 && rangeFieldEndValue != "undefined"){
                        filter_settings_string += " to " + rangeFieldEndValue;
                    }
                @endforeach
            @endif


            $('#txt-{{$control_id}}-filter-settings').html(filter_settings_string);
        });

        $(document).on('click', "#btn-reset-mdl-{{ $control_id }}-filter-modal", function(e) {
            $("#frm-{{$control_id}}-filter-modal").trigger("reset");
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}");
            $('#mdl-{{ $control_id }}-filter-modal').modal('hide');
            $('#txt-{{$control_id}}-filter-settings').html('');
        });

        @if (isset($filter_group_range_select) && count($filter_group_range_select)>0)
            @foreach($filter_group_range_select as $filter_range_select_group=>$filter_range_select_options)
                $(document).on('input', "#rng-filter-{{$control_id}}-{{str_replace(",","",$filter_range_select_options[0])}}", function(e) {
                    var range_value = new Intl.NumberFormat().format($(this).val());
                    $("#lbl-rng-filter-{{$control_id}}-{{str_replace(",","",$filter_range_select_options[0])}}").html(range_value);
                    $("#rng-filter-{{$control_id}}-{{str_replace(",","",$filter_range_select_options[0])}}").attr("data-val-is-entered", 1);
                });
            @endforeach
        @endif
        
    });
</script>
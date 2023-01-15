

<script type="text/javascript">
    $(document).ready(function() {
        let page_total = 0;
        let current_page = 0;

        {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}");


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

            //check for internet status 
            if (!window.navigator.onLine) {
                $('.offline').fadeIn(300);
                return;
            }else{
                $('.offline').fadeOut(300);
            }

            $("#spinner-{{$control_id}}").show();
            $('#{{$control_id}}-div-card-view').empty();
            $('#{{$control_id}}-div-card-view').append("<span class='text-center ma-20 pa-20'>Loading.....</span>");
           
            $.get(endpoint_url).done(function( response ) {
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
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+search_term_query);
        });

        $(document).on('click', "#{{$control_id}}-btn-search", function(e) {
            e.preventDefault();
            let search_term = $('#{{$control_id}}-txt-search').val();
            let search_term_query = "?st="+search_term;
            @if(!empty(request()->query()) && count(request()->query()) > 0)
                search_term_query = "&st="+page_number;
            @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+search_term_query);
        });

        $(document).on('click', ".{{$control_id}}-grp", function(e) {
            e.preventDefault();
            let group_term = $(this).attr('data-val');
            $("#{{$control_id}}-pagination").hide();
            let group_term_query = "?grp="+group_term;
            @if(!empty(request()->query()) && count(request()->query()) > 0)
                group_term_query = "&grp="+group_term;
            @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+group_term_query);
            
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
           @if(!empty(request()->query()) && count(request()->query()) > 0)
                pg_query = "&pg="+page_number;
           @endif
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}"+pg_query);
            
        });
        
    });
</script>
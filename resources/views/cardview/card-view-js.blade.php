

<script type="text/javascript">
    $(document).ready(function() {
    
        {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}");

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
                console.log(response);
                if (response != null && response.cards_html != null){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append(response.cards_html);
                }
                if (response != null && response.result_count==0){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append("<span class='text-center ma-20 pa-20' style='padding-bottom:100px'>No results found.</span>");
                }
                if (response != null && response.paginate && response.result_count > 0){
                    $("#{{$control_id}}-pagination").empty();
                    for(let pg=1;pg<=response.pages_total;pg++){
                        $("#{{$control_id}}-pagination").append("<li><a data-val='"+pg+"' class='{{$control_id}}-pg' href='#'>"+pg+"</a></li>");
                        (response.page_number == pg) ? $('.{{$control_id}}-pg').addClass('cdv-current-page') : $('.{{$control_id}}-pg').addClass('text-primary') ;
                    }
                    $("#{{$control_id}}-pagination").show();
                }
                $("#spinner-{{$control_id}}").hide();
            });
        }

        $(document).on('keyup', "#{{$control_id}}-txt-search", function(e) {
            e.preventDefault();
            let search_term = $('#{{$control_id}}-txt-search').val();
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}?st="+search_term);
        });

        $(document).on('click', "#{{$control_id}}-btn-search", function(e) {
            e.preventDefault();
            let search_term = $('#{{$control_id}}-txt-search').val();
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}?st="+search_term);
        });

        $(document).on('click', ".{{$control_id}}-grp", function(e) {
            e.preventDefault();
            let group_term = $(this).attr('data-val');
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}?grp="+group_term);
        });

        $(document).on('click', ".{{$control_id}}-pg", function(e) {
            e.preventDefault();
            $("#{{$control_id}}-pagination").hide();
            let page_number = $(this).attr('data-val');
            {{$control_id}}_display_results("{{$control_obj->getJSONDataRouteName()}}?pg="+page_number);
        });
        
    });
</script>
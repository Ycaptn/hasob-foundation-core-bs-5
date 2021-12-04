

<script type="text/javascript">
    $(document).ready(function() {
    
        {{$control_id}}_display_results("{{url()->full()}}");

        function {{$control_id}}_display_results(endpoint_url){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN':"{{ csrf_token() }}"}});
            $('#{{$control_id}}-div-card-view').empty();
            $('#{{$control_id}}-div-card-view').append("<span class='text-center ma-20 pa-20'>Loading.....</span>");

            $.get(endpoint_url).done(function( response ) {
                if (response != null && response.cards_html != null){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append(response.cards_html);
                }
                if (response != null && response.result_count==0){
                    $('#{{$control_id}}-div-card-view').empty();
                    $('#{{$control_id}}-div-card-view').append("<span class='text-center ma-20 pa-20' style='padding-bottom:100px'>No results found.</span>");
                }
                if (response != null && response.paginate){
                    $("#{{$control_id}}-pagination").empty();
                    for(let pg=1;pg<=response.pages_total;pg++){
                        $("#{{$control_id}}-pagination").append("<li><a data-val='"+pg+"' class='{{$control_id}}-pg text-primary' href='#'>"+pg+"</a></li>");
                    }
                }
            });
        }

        $(document).on('keyup', "#{{$control_id}}-txt-search", function(e) {
            let search_term = $('#{{$control_id}}-txt-search').val();
            {{$control_id}}_display_results("{{url()->full()}}?st="+search_term);
        });

        $(document).on('click', "#{{$control_id}}-btn-search", function(e) {
            let search_term = $('#{{$control_id}}-txt-search').val();
            {{$control_id}}_display_results("{{url()->full()}}?st="+search_term);
        });

        $(document).on('click', ".{{$control_id}}-grp", function(e) {
            let group_term = $(this).attr('data-val');
            {{$control_id}}_display_results("{{url()->full()}}?grp="+group_term);
        });

        $(document).on('click', ".{{$control_id}}-pg", function(e) {
            let page_number = $(this).attr('data-val');
            {{$control_id}}_display_results("{{url()->full()}}?pg="+page_number);
        });
        
    });
</script>
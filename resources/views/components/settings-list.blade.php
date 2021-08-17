



<div class="row">

    <div class="col-lg-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pt-0">

                    @if (isset($settings) && count($settings)>0)

                        <div class="pills-struct">
                            <ul role="tablist" class="nav nav-pills" id="settings_tab">
                                @foreach($groups as $idx=>$group)
                                @php
                                    $active_str = "";
                                    if ($idx == 0){
                                        $active_str = "active";
                                    }
                                @endphp
                                <li role="presentation" class="{{ $active_str }}">
                                    <a data-toggle="tab" id="tab_{{$idx}}" role="tab" href="#settings_tab_{{$idx}}" aria-expanded="false">
                                        {{ $group }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="settins_tab_content">

                                @foreach($groups as $idx=>$group)
                                @php
                                    $active_str = "";
                                    if ($idx == 0){
                                        $active_str = "active";
                                    }
                                @endphp
                                <div id="settings_tab_{{$idx}}" class="tab-pane fade {{ $active_str }} in" role="tabpanel">
                                    
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">Key</th>
                                                        <th width="50%">Value</th>
                                                        <th width="20%">Group</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($settings as $item)
                                                    @php
                                                        if ($item->group_name != $group){
                                                            continue;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td width="30%">                                                
                                                            <a href="javascript:void(0)" class="pr-5 text-primary btn-edit-mdl-setting-modal" data-val="{{$item->id}}" data-toggle="tooltip" title="" data-original-title="Edit" aria-describedby="tooltip563536">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" class="pr-10 text-primary btn-delete-mdl-setting-modal" data-val="{{$item->id}}" data-toggle="tooltip" title="" data-original-title="Delete" aria-describedby="tooltip563">
                                                                <i class="fa fa-trash text-danger"></i>
                                                            </a>
                                                            {{$item->key}}
                                                        </td>
                                                        <td>
                                                            {{$item->value}}
                                                        </td>
                                                        <td>
                                                            {{$item->group_name}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>

                    @else
                        <p>No Settings, use the add button to add a setting.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
        
    <div class="modal fade" id="mdl-setting-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 id="lbl-setting-modal-title" class="modal-title">Setting</h4>
                </div>

                <div class="modal-body">
                    <div id="div-setting-modal-error" class="alert alert-danger" role="alert"></div>
                    <form class="form-horizontal" id="frm-setting-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                        <div class="row">
                            <div class="col-lg-12 ma-10">
                                @csrf

                                <div id="spinner-settings" class="">
                                    <div class="loader" id="loader-1"></div>
                                </div>

                                <input type="hidden" id="txt-setting-primary-id" value="0" />
                                <div id="div-show-txt-setting-primary-id">
                                    <div class="row">
                                        <div class="col-lg-10 ma-10">
                                        </div>
                                    </div>
                                </div>
                                <div id="div-edit-txt-setting-primary-id">
                                    <div class="row">
                                        <div class="col-lg-10 ma-10">
                                        
                                            <!-- Key Field -->
                                            <div id="div-key" class="form-group">
                                                <label class="control-label mb-10 col-sm-3" for="key">Key</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('key', null, ['id'=>'key','class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
                                                </div>
                                            </div>

                                            <!-- Value Field -->
                                            <div id="div-value" class="form-group">
                                                <label class="control-label mb-10 col-sm-3" for="value">Value</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('value', null, ['id'=>'value','rows'=>'3','class'=>'form-control']) !!}
                                                </div>
                                            </div>

                                            <!-- Group Name Field -->
                                            <div id="div-group_name" class="form-group">
                                                <label class="control-label mb-10 col-sm-3" for="group_name">Group Name</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('group_name', null, ['id'=>'group_name','class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <hr class="light-grey-hr mb-10" />
                    <button type="button" class="btn btn-primary" id="btn-save-mdl-setting-modal" value="add">Save</button>
                </div>

            </div>
        </div>
    </div>

</div>



@push('page_scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
        //Show Modal for New Entry
        $(document).on('click', ".btn-new-mdl-setting-modal", function(e) {
            $('#div-setting-modal-error').hide();
            $('#mdl-setting-modal').modal('show');
            $('#frm-setting-modal').trigger("reset");
            $('#txt-setting-primary-id').val(0);

            $('#div-show-txt-setting-primary-id').hide();
            $('#div-edit-txt-setting-primary-id').show();

            $("#spinner-settings").hide();
            $("btn-save-mdl-setting-modal").attr('disabled', false);
        });

        //Show Modal for Edit
        $(document).on('click', ".btn-edit-mdl-setting-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            $('#div-setting-modal-error').hide();
            $('#mdl-setting-modal').modal('show');
            $('#frm-setting-modal').trigger("reset");

            $("#spinner-settings").show();
            $("btn-save-mdl-setting-modal").attr('disabled', true);

            $('#div-show-txt-setting-primary-id').hide();
            $('#div-edit-txt-setting-primary-id').show();
            let itemId = $(this).attr('data-val');

            $.get( "{{ route('fc.settings.show','') }}/"+itemId).done(function( data ) {     

                $('#txt-setting-primary-id').val(data.response.id);

                $('#key').val(data.response.key);
                $('#value').val(data.response.value);
                $('#group_name').val(data.response.group_name);

                $("#spinner-settings").hide();
                $("btn-save-mdl-setting-modal").attr('disabled', false);
            });
        });

        //Delete action
        $(document).on('click', ".btn-delete-mdl-setting-modal", function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            let itemId = $(this).attr('data-val');
            if (confirm("Are you sure you want to delete this Setting?")){

                let endPointUrl = "{{ route('fc.settings.destroy',0) }}"+itemId;

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('_method', 'DELETE');
                
                $.ajax({
                    url:endPointUrl,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    dataType: 'json',
                    success: function(result){
                        if(result.errors){
                            console.log(result.errors)
                        }else{
                            window.alert("The Setting has been deleted.");
                            location.reload(true);
                        }
                    },
                });            
            }
        });

        //Save details
        $('#btn-save-mdl-setting-modal').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

            $("#spinner-settings").show();
            $("btn-save-mdl-setting-modal").attr('disabled', true);

            let actionType = "POST";
            let endPointUrl = "{{ route('fc.settings.store') }}";
            let primaryId = $('#txt-setting-primary-id').val();
            
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());

            if (primaryId != "0"){
                actionType = "PUT";
                endPointUrl = "{{ route('fc.settings.update','') }}"+primaryId;
                formData.append('id', primaryId);
            }
            
            formData.append('_method', actionType);
            formData.append('key', $('#key').val());
            formData.append('value', $('#value').val());
            formData.append('group_name', $('#group_name').val());

            $.ajax({
                url:endPointUrl,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                dataType: 'json',
                success: function(result){
                    if(result.errors){
                        $('#div-setting-modal-error').html('');
                        $('#div-setting-modal-error').show();
                        
                        $.each(result.errors, function(key, value){
                            $('#div-setting-modal-error').append('<li class="">'+value+'</li>');
                        });
                    }else{
                        $('#div-setting-modal-error').hide();
                        window.setTimeout( function(){
                            window.alert("The Setting saved successfully.");
                            $('#div-setting-modal-error').hide();
                            location.reload(true);
                        },20);
                    }

                    $("#spinner-settings").hide();
                    $("btn-save-mdl-setting-modal").attr('disabled', false);
                    
                }, error: function(data){
                    console.log(data);

                    $("#spinner-settings").hide();
                    $("btn-save-mdl-setting-modal").attr('disabled', false);

                }
            });
        });    

    });
</script>
@endpush
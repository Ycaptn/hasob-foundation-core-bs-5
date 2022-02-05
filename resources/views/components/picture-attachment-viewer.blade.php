
@if ($attachable!=null)

@push('page_css')
<style type="text/css">
    @media (min-width: 768px) {
        .modal-xl {
            width: 90%;
            max-width:1200px;
        }
    }
    #attachment-viewer-modal > .modal {
        height: 100vh;
    }
    #attachment-viewer-modal > .modal-dialog {
        height: 100vh;
    }
    #attachment-viewer-modal > .modal-content {
        height: 95vh;
    }
</style>
@endpush


@php
    $attachments = $attachable->get_attachments($file_types);
@endphp

@if (count($attachments) > 0)

    <div class="row mb-15">
        <div class="col-xs-7">
            @if ($show_tags==true && $attachable->tags!=null && count($attachable->tags)>0)
            @foreach($attachable->tags as $key=>$tag)
                <button data-val="{{$tag->id}}" class="{{$tag->id}}-grp btn btn-xxs btn-primary btn-outline faded mr-5">{{$tag->name}}</button>
            @endforeach
            @endif
        </div>
    </div>

    @if ($display_style=="grid")
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    
                    @foreach($attachments as $key=>$attachment)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12  file-box">
                        <div class="file">
                            <a href="#" class="{{$control_id}}_picture-box-view" data-val-image-path="{{route('fc.attachment.show', $attachment->id)}}">
                                
                                <div class="image" style="background-image:url({{route('fc.attachment.show', $attachment->id)}})"></div>
                                <div class="file-name">
                                    {{ $attachment->label }}
                                    <br>
                                    <span class="small">
                                        {{ \Carbon\Carbon::parse($attachment->created_at)->format('d M y') }} <span class="small text-danger">- {!! \Carbon\Carbon::parse($attachment->created_at)->diffForHumans() !!}</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    @elseif ($display_style=="carousel")
        
    @endif


    <div class="modal fade" id="{{$control_id}}_picture-viewer-modal" role="dialog" aria-labelledby="{{$control_id}}_picture-viewer-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <center>
                                <img id="{{$control_id}}_picture-box" class="img-responsive" />
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('.{{$control_id}}_picture-box-view').click(function(){
                let image_path = $(this).attr('data-val-image-path');
                $('#{{$control_id}}_picture-box').attr("src",image_path);
                $('#{{$control_id}}_picture-viewer-modal').modal('show');
            });

        });
    </script>
    @endpush

@else
    <center class="ma-20">No Pictures</center>
@endif

@endif
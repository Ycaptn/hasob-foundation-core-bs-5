@if ($attachable!=null)

    @php
        $attachments = $attachable->get_attachments($file_types);
    @endphp

    @if (count($attachments)>0)
        <div class="streamline user-activity mt-10">
        @foreach ($attachments as $idx => $attach)

            <div class="sl-item small">
                <a href="javascript:void(0)">
                    <div class="d-flex p-2 ">
                        <div class="sl-avatar avatar avatar-sm avatar-circle mt-2">
                            <a href="{{ route('fc.attachment.show', $attach->id) }}"  target="_blank">
                                <i class="fa fa-paperclip fa-3x"></i>
                            </a>
                        </div>
                        <div class="ms-4">
                            <p class="small text-center">
                                <span class="capitalize-font txt-primary mr-5 weight-500">
                                    <a href="{{ route('fc.attachment.show', $attach->id) }}" target="_blank">
                                        <strong>{{ $attach->label }}</strong>
                                    </a>
                                </span>
                                @if (empty($attach->description) == false)
                                <br/>
                                <span class="$text_color">
                                    {{ $attach->description }}
                                </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div>
                        <span class="block small txt-grey capitalize-font mb-2">
                            <i class="fa fa-upload"></i> {{$attach->uploader->full_name}} on {{$attach->getCreatedDateString()}}
                        </span>
                    </div>
                    
                    
                </a>
            </div>

        @endforeach
        </div>
    @else
        <div class="text-center">No Files</div>
    @endif

@endif
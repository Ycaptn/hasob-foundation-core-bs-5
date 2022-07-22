@if ($attachable!=null)

    @php
        $attachments = $attachable->get_attachments($file_types);
    @endphp

    @if (count($attachments)>0)
        <div class="list-group mt-3">
        @foreach ($attachments as $idx => $attach)
            <a href="{{ route('fc.attachment.show', $attach->attachment_id) }}" target="_blank" class="list-group-item list-group-item-action">


                <div class="d-flex align-items-center">
                    <i class="fa fa-paperclip fa-2x"></i>
                    <div class="flex-grow-1 ms-3">
                        <p class="mt-0 mb-0">{{ $attach->label }}</p>
                        <p class="mb-1 $text_color">
                            @if (empty($attach->description) == false)
                                {{ $attach->description }}
                            @endif
                            <small class="text-muted">
                                <small><i class="fa fa-upload"></i> {{$attach->user->full_name}} on {{$attach->getCreateDateString()}}</small>
                            </small>
                        </p>
                    </div>
                </div>

            </a>
        @endforeach
        </div>
    @else
        <div class="text-center">No Files</div>
    @endif

@endif
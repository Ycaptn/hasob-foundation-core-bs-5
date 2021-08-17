@if (isset($commentable) && $commentable != null)
<div class="streamline user-activity">
    @foreach ($commentable->get_comments() as $comment)

        @php
            $text_color= "black";
            if ($comment->user->is_principal_officer){
                $text_color= "red";
            }
        @endphp

        <div class="sl-item small">
            <a href="javascript:void(0)">
                <div class="sl-avatar avatar avatar-sm avatar-circle">
                    @if ( $comment->user->profile_image == null )
                        <img class="img-circle" src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                    @else
                        <img class="img-circle" src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                    @endif
                </div>
                <div class="sl-content">
                    <p class="inline-block small">
                        <span class="capitalize-font txt-primary mr-5 weight-500">{{$comment->user->full_name}}</span>
                        <span class="$text_color">{{$comment->content}}</span>
                    </p>
                    <span class="block small txt-grey font-12 capitalize-font">{{$comment->getCommentedDateString()}}</span>
                </div>
            </a>
        </div>

    @endforeach
</div>    
@endif
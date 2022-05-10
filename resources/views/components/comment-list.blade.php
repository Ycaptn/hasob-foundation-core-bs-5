@if (isset($commentable) && $commentable != null)
    <div class="streamline user-activity">
        @foreach ($commentable->get_comments() as $comment)
            @php
                $text_color = 'black';
                if ($comment->user->is_principal_officer) {
                    $text_color = 'red';
                }
            @endphp

            {{-- <div class="sl-item small">
           <a href="javascript:void(0)">
                <div class="sl-avatar avatar avatar-sm avatar-circle">
                    @if ($comment->user->profile_image == null)
                        <img class="img-circle" src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                    @else
                        <img class="img-circle" src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                    @endif
                </div>
                <div class="sl-content" style="padding-bottom: 0;">
                    <p class="inline-block small">
                        <span class="capitalize-font txt-primary mr-5 weight-500">{{$comment->user->full_name}}</span>
                        <span class="$text_color" id="comment_{{$comment->id}}">{{$comment->content}}</span>
                    </p>   
                </div>
            </a>  
            <div class="d-flex align-items-center">
                    <a href="javascript:void(0)">
                        <div class="sl-avatar avatar avatar-sm avatar-circle">
                            @if ($comment->user->profile_image == null)
                                <img width="42" height="42" class="rounded-circle" alt="" src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                            @else
                                <img width="42" height="42" class="rounded-circle" alt="" src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                            @endif
                        </div>
                    </a>
                    <div class="d-flex flex-grow-1 ms-2">
                        <div  class="d-flex justify-content-between flex-grow-1 ms-2">
                            <div>
                                <p class="mb-0 font-weight-bold">
                                    <span class="capitalize-font txt-primary mr-5 weight-500">{{$comment->user->full_name}}</span>
                                </p>
                            </div>
                            <div>
                                <span class="block small txt-grey font-12 capitalize-font">{{$comment->getCommentedDateString()}} &nbsp;
                                    @if ($comment->user_id == auth()->user()->id)
                                    <a data-toggle="tooltip" 
                                    title="Edit" 
                                    data-val='{{$comment->id}}' 
                                    class="btn-edit-mdl-comment-modal inline-block " href="#">
                                    <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
                                    </a> 
                                    @endif  
                                </span>
                            </div>
                        </div>
                    </div>
                <p class="inline-block small">
                        <span class="$text_color" id="comment_{{$comment->id}}">{{$comment->content}}</span>
                    </p>  
            </div>
                
                <div>
			</div>
        </div> --}}

            <div class="d-flex align-items-center mb-3">
                <div class="sl-avatar avatar avatar-sm avatar-circle">
                    <a href="javascript:void(0)">
                        @if ($comment->user->profile_image == null)
                            <img width="42" height="42" class="rounded-circle"
                                src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                        @else
                            <img width="42" height="42" class="rounded-circle"
                                src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                        @endif
                    </a>
                </div>
                <div class="flex-grow-1 ms-2">

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="javascript:void(0)">
                                <p class="mb-0 font-weight-bold">
                                    <span
                                        class="capitalize-font txt-primary mr-5 weight-500">{{ $comment->user->full_name }}</span>
                                </p>
                            </a>
                        </div>
                        <div>
                            <span
                                class="block small txt-grey font-12 capitalize-font">{{ $comment->getCommentedDateString() }}
                                &nbsp;
                                @if ($comment->user_id == auth()->user()->id)
                                    <a data-toggle="tooltip" title="Edit" data-val='{{ $comment->id }}'
                                        class="btn-edit-mdl-comment-modal inline-block " href="#">
                                        <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
                                    </a>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="">
                        <p class="inline-block small">
                            <span class="$text_color" id="comment_{{ $comment->id }}">{{ $comment->content }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

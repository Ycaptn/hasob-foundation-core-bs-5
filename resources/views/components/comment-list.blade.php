@if (isset($commentable) && $commentable != null)
    <div class="streamline user-activity">
        @foreach ($commentable->get_comments()->sortByDesc('created_at') as $comment)
            @php
                $text_color = 'black';
                if ($comment->user->is_principal_officer) {
                    $text_color = 'red';
                }
            @endphp

            <div class="d-flex align-items-center mb-2" style="border-bottom: 1px solid #e4e4e4;">
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
                                        class="capitalize-font txt-primary me-2 weight-500">{{ $comment->user->full_name }}</span>
                                </p>
                            </a>
                        </div>
                        <div>
                            <span
                                class="block small text-secondary font-12 capitalize-font">{{ $comment->getCommentedDateString() }}
                                &nbsp;
                                @if (\Auth::check() && $comment->user_id == auth()->user()->id)
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
                            <span class="$text_color"
                                id="comment_{{ $comment->id }}">{{ $comment->content }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if (isset($commentable) && $commentable != null)
<div class="streamline user-activity">
    @foreach ($commentable->get_comments() as $comment)

        @php
            $text_color= "black";
            if ($comment->user->is_principal_officer){
                $text_color= "red";
            }
        @endphp

        {{-- <div class="sl-item small d-flex">
            <a href="javascript:void(0)">
                <div class="d-flex">
                    <div class="">
                        @if ( $comment->user->profile_image == null )
                           <img class="user-auth-img card-user-img img-circle float-start" src="{{asset('imgs/user.png')}}" alt="user">
                        @else
                            <img class="img-fluid" src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                        @endif
                    </div>
                    <div class="sl-content col-lg-10" style="padding-bottom: 0;">
                        <p class="inline-block small">
                            <span class="capitalize-font txt-primary mr-5 weight-500">{{$comment->user->full_name}}</span>
                        </p>
                        <p>
                            <span class="$text_color" id="comment_{{$comment->id}}">{{$comment->content}}</span>
                        </p>  
                    </div>
                </div>
                
                
            </a> 
            <div class="sl-content float-end">  
                <span class="block small txt-grey font-12 capitalize-font">{{$comment->getCommentedDateString()}} &nbsp;
                    @if($comment->user_id == auth()->user()->id)
                    <a data-toggle="tooltip" 
                    title="Edit" 
                    data-val='{{$comment->id}}' 
                    class="btn-edit-mdl-comment-modal inline-block " href="#">
                    <i class="zmdi zmdi-border-color txt-warning" style="opacity:80%"></i>
                    </a> 
                    @endif  
                </span>
           
            </div>
        </div> --}}
        
        <div class="d-flex">
            
            <div>
                <a href="javascript:void(0)">
                    @if ( $comment->user->profile_image == null )
                        <img class="user-auth-img card-user-img img-circle float-start" src="{{asset('imgs/user.png')}}" alt="user">
                    @else
                        <img class="img-fluid" src="{{ route('fc.get-profile-picture', $comment->user->id) }}" />
                    @endif
                </a>
            </div>
			<div class="flex-grow-1 ms-4">
                <a href="javascript:void(0)">
                    <p class="mb-0 font-weight-bold">
                        <span class="capitalize-font txt-primary mr-5 weight-500">{{$comment->user->full_name}}</span>
                    </p>
                    
                    <p>
                        <span class="$text_color" id="comment_{{$comment->id}}">{{$comment->content}}</span>
                    </p>
                </a> 
			</div> 
            <div class="">  
                <span class="block small txt-grey font-12 capitalize-font">{{$comment->getCommentedDateString()}} &nbsp;
                    @if($comment->user_id == auth()->user()->id)
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

    @endforeach
</div>    
@endif
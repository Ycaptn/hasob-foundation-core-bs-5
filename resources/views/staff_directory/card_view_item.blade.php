<div class="col col-md-6 flex-column">
    <div class="card radius-10">
        <div class="d-flex align-items-center p-2">
            
            @if ( $data_item->profile_image == null )
                {{-- <img style="width:60px;" class="ms-2 rounded-circle p-1 border" src="{{ asset('imgs/user.png') }}" > --}}
                <div class="fm-icon-box rounded-circle p-1 border bg-light text-primary text-center">
                    <i class="bx bx-user-pin"></i>
                </div>
            @else
                <img style="max-width:60px;" class="ms-2 rounded-circle p-1 border" src="{{ route('fc.get-profile-picture', $data_item->id) }}" alt="{{$data_item->full_name}}">
            @endif
            
            <div class="flex-grow-1 ms-3">
                <h6 class="text-primary mt-0 mb-0">{{  $data_item->full_name }}</h6>

                <p class="card-text small mb-0">
                    @if ($data_item->department != null)
                    {{ $data_item->department->long_name }}
                    @endif
                </p>

                <p class="card-text small mb-0">
                    @if (!empty($data_item->job_title))
                        {{ $data_item->job_title }}
                    @endif
                </p>

                <p class="card-text small mb-0">
                    <i class="fa fa-envelope text-muted" style="opacity:70%;"></i> {{ $data_item->email }} &nbsp; 
                    <i class="fa fa-mobile text-muted" style="opacity:70%;"></i> {{ $data_item->telephone }}
                </p>
                
                    <p class="card-text small mb-0"></p>
                {{-- <p class="card-text small mb-0">
                    @if ($data_item->last_loggedin_at != null)
                    Last Seen {{$data_item->last_loggedin_at->diffForHumans()}}
                    @else
                        Never Logged in.
                    @endif
                </p> --}}
                {{-- <p 
                    style="color:{{ ($data_item->presence_status=='available') ? 'green' : 'red' }};"
                    class="card-text small mb-0 fst-italic"
                >
                    {{ $data_item->presence_status }}                    
                </p> --}}
            </div>
            
        </div>
    </div>
</div>

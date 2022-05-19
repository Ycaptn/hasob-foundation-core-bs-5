
    <div class="card">
        <div class="card-body">
            @if (count($department->members) > 0)

                <ul class="list-unstyled">
                @foreach($department->members as $idx=>$member)

                    <li class="d-flex align-items-center border-bottom pb-2">
                        @if ( $member->profile_image == null )
                            <img width="42" height="42" class="rounded-circle p-1 border" src="{{ asset('hasob-foundation-core/imgs/bare-profile.png') }}" />
                        @else
                            <img width="42" height="42" class="rounded-circle p-1 border" src="{{ route('fc.get-profile-picture', $member->id) }}" />
                        @endif
                        <div class="flex-grow-1 ms-3">
                            <p class="mt-0 mb-1 fs-6">{{ $member->full_name }}</p>

                            @if (isset($member->job_title) && empty($member->job_title) == false)
                                <p class="card-text mb-0">{!! $member->job_title !!}</p>
                            @endif

                            @if (isset($member->telephone) && empty($member->telephone) == false)
                                <a href="tel:{{$member->telephone}}">
                                    <span class="card-text small">
                                        <i class="fa fa-phone-square gray-200"></i> {!! $member->telephone !!}
                                    </span>
                                </a>
                                <br/>
                            @endif

                            @if (isset($member->email) && empty($member->email) == false)
                                <a href="mailto:{{$member->email}}">
                                    <span class="card-text small"><i class="fa fa-envelope gray-200"></i> {!! $member->email !!}</span>
                                </a>
                            @endif
                        </div>
                    </li>

                @endforeach
                </ul>

            @else
                <p class="small text-center m-2">No Persons in this Department</p>
            @endif    
        </div>
    </div>


@if (count($department->children()) > 0)    
    @foreach($department->children() as $idx=>$department)

        <div class="col-12 col-md-12">
            <div class="card department-item">
                <div class="row g-0 align-items-center">
                
                    <div class="col-xs-12 col-md-12">
                        <div class="card-body">
                            <a href="{{ route('fc.departments.show',$department->id) }}">
                            <h3 class="h6 card-title mb-0">{{ $department->long_name }}</h3>
                            </a>
                            <p class="card-text mb-0">{!! $department->physical_location !!}</p>
                                                    
                            @if (isset($department->telephone) && empty($department->telephone) == false)
                            <a href="tel:{{$department->telephone}}">
                                <span class="card-text small">
                                    <i class="fa fa-phone-square gray-200"></i> {!! $department->telephone !!}
                                </span>
                            </a>
                            <br/>
                            @endif

                            @if (isset($department->email) && empty($department->email) == false)
                            <a href="mailto:{{$department->email}}">
                                <span class="card-text small"><i class="fa fa-envelope gray-200"></i> {!! $department->email !!}</span>
                            </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    @endforeach
@endif    


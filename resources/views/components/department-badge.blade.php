

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
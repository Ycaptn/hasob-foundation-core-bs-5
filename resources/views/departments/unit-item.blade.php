<div class="col-6 col-md-6 col-sm-12">
    <div class="card shadow department-item">
        <div class="row g-0 align-items-center">
            <div class="col-xs-12 col-md-2 align-middle text-center p-2">
                @if ($data_item->logo_image != null)
                    <img width="42" height="42" class="img-fluid text-center rounded-circle p-1 border"
                        src="{{ route('fc.get-dept-picture', $data_item->id) }}" />
                @else
                    <div class="fm-icon-box radius-10 bg-primary text-white text-center">
                        <i class="bx bxs-door-open"></i>
                    </div>
                @endif
                @if (\Auth::user() != null && \Auth::user()->hasAnyRole('admin', 'departments-admin'))
                    <span class="card-text text-center">
                        <a data-toggle="tooltip" 
                            title="Edit" 
                            data-val="{{ $data_item->id }}"
                            data-original-title="Edit"
                            class="btn-edit-mdl-department-unit-modal" href="#">
                            <i class="bx bxs-edit text-warning"></i>
                        </a>
                        <a data-toggle="tooltip" 
                            title="Delete" 
                            data-val="{{ $data_item->id }}"
                            data-original-title="Delete"
                            class="btn-delete-mdl-department-unit-modal" href="#">
                            <i class="bx bxs-trash-alt text-danger"></i>
                        </a>
                    </span>
                @endif
            </div>
            <div class="col-xs-12 col-md-10">
                <div class="card-body">
                    <a href="{{ route('fc.departments.show', $data_item->id) }}">
                        <h3 class="h6 card-title mb-0">{{ $data_item->long_name }}</h3>
                    </a>
                    <p class="card-text mb-0">{!! $data_item->physical_location !!}</p>
                    <div class="d-flex justify-content-between align-items-start">

                        @if (isset($data_item->telephone) && empty($data_item->telephone) == false)
                            <span class="card-text small me-2">
                                <i class="fa fa-phone-square gray-200"></i> {!! $data_item->telephone !!}
                            </span>
                        @endif

                        @if (isset($data_item->email) && empty($data_item->email) == false)
                            <span class="card-text small me-2">
                                <i class="fa fa-envelope gray-200"></i> {!! $data_item->email !!}
                            </span>
                        @endif
                        <span class="card-text small ms-auto">
                        </span>
                    </div>
                    @include('hasob-foundation-core::departments.departments-units-modal')
                </div>
            </div>
        </div>
    </div>
</div>

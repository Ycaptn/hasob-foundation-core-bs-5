<div class="col col-md-6 flex-column">
    <div class="card site-item">
        <div class="row g-0">
            <div class="col-lg-2 text-center mt-3">

                <a href="{{ route('fc.sites.show', $data_item->id) }}">
                    <i class="fa fa-3x fa-globe"></i>
                </a>

                <div class="text-center mt-2">
                    {{-- <a data-bs-toggle="tooltip" title="view" data-val="{{ $data_item->id }}"
                        data-bs-toggle="tooltip" data-original-title="view"
                        class="btn-show-mdl-site-modal inline-block me-1" href="#">
                        <i class="fa fa-files-o text-primary" style="opacity:80%"></i>
                    </a> --}}

                    @if (\Auth::user() != null && \Auth::user()->hasAnyRole('admin', 'department-admin'))
                        <a href="#" 
                            data-bs-toggle="tooltip" 
                            title="Edit" 
                            data-val="{{ $data_item->id }}"
                            data-bs-toggle="tooltip" 
                            data-original-title="Edit"
                            class="btn-edit-mdl-site-modal me-1" > 
                            <i class="bx bxs-edit text-warning"></i>
                        </a>
                        <a href="#"
                            data-bs-toggle="tooltip" 
                            title="Delete" 
                            data-val="{{ $data_item->id }}"
                            data-bs-toggle="tooltip" 
                            data-original-title="Delete"
                            class="btn-delete-mdl-site-modal me-1">
                            <i class="bx bxs-trash-alt text-danger"></i>
                        </a>
                    @endif
                </div>

            </div>
            <div class="col-lg-10">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div>
                            <h4 class="card-title mb-0">
                                <a href="{{ route('fc.sites.show', $data_item->id) }}">{{ $data_item->site_name }}</a>
                            </h4>
                        </div>
                    </div>

                    <p class="mb-0 small">
                        @if (empty($data_item->description) == false)
                            {!! \Illuminate\Support\Str::limit($data_item->description, 50, ' ...') !!}
                        @else
                            No Description
                        @endif
                    </p>
                    <p class="mb-0 small">                        
                        @php
                            $site_id = empty($data_item->site_path) ? $data_item->id : $data_item->site_path;
                        @endphp
                        <a href="{{ route('fc.site-display.index', $site_id) }}">
                            {!! \Illuminate\Support\Str::limit(route('fc.site-display.index', $site_id), 50, ' ...') !!}
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

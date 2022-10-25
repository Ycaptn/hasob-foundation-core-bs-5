
<div class="col-12 col-md-12 col-sm-12">
    <div class="card">
        @php
            $detail_page_url = route('fc.documentGenerationTemplates.show', $data_item->id);
        @endphp
        <div class="row g-0">
            <div class="col-xs-12 col-md-1 align-middle text-center p-2">
                <a href='#' data-val='{{$data_item->id}}' class="btn-edit-mdl-documentGenerationTemplate-modal">
                    @if ( $data_item->logo_image != null )
                        <img width="42" height="42" class="ms-2 img-fluid text-center rounded-circle p-1 border" src="{{ route('fc.get-dept-picture', $data_item->id) }}" />
                    @else
                        <div class="ms-2 fm-icon-box radius-10 bg-primary text-white text-center">
                            <i class="bx bx-message-square-edit"></i>
                        </div>
                    @endif
                </a>
                <div class="d-flex align-items-center">
                    <div class="ms-auto"> 
                        <a data-toggle="tooltip" 
                            title="Edit" 
                            data-val='{{$data_item->id}}' 
                            class="btn-edit-mdl-documentGenerationTemplate-modal me-1" href="#">
                            <i class="bx bxs-edit"></i>
                        </a>
                        <a data-toggle="tooltip" 
                            title="Delete" 
                            data-val='{{$data_item->id}}' 
                            class="btn-delete-mdl-documentGenerationTemplate-modal me-1" href="#">
                            <i class="bx bxs-trash-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-11">
                <div class="card-body">
                    <a href='#' data-val='{{$data_item->id}}' class="btn-edit-mdl-documentGenerationTemplate-modal">
                        <h3 class="h6 card-title mb-0">
                            {{ $data_item->title }}
                        </h3>
                    </a>
                    @if (!empty($data_item->output_content_types))
                        <p class="card-text mb-0 small">
                            {{ $data_item->output_content_types }}
                        </p>
                    @endif

                    <p class="card-text text-muted small">
                        Created: {{ \Carbon\Carbon::parse($data_item->created_at)->format('l jS F Y') }} - {!! \Carbon\Carbon::parse($data_item->created_at)->diffForHumans() !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
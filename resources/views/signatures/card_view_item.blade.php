<div class="col col-md-6 flex-column">
    <div class="card radius-10">
        <div class="d-flex align-items-center p-2">
            
            @if ( $data_item->signature_image == null )
                <div class="fm-icon-box p-1 border bg-light text-primary text-center">
                    <i class="bx bx-user-pin"></i>
                </div>
            @else
                <img style="max-width:80px;" class="ms-2 p-1 border" src="{{ route('fc.signature.view-item', $data_item->id) }}" alt="{{$data_item->staff_name}}">
            @endif
            
            <div class="flex-grow-1 ms-3">
                <h6 class="text-primary mt-0 mb-0">{{  $data_item->user->full_name }}</h6>

                <p class="card-text small mb-0">
                    @if ($data_item->staff_title != null)
                    {{ $data_item->staff_title }}
                    @endif
                </p>

                <p class="card-text small mb-0">
                    @if (!empty($data_item->on_behalf))
                        <i class="text-primary">for: {{ $data_item->on_behalf }}</i>
                    @endif
                </p>
                
            </div>
            <div>
                <a href="#"><i class="fa fa-edit fa-fw btn-edit-mdl-signatory-item-modal" data-val="{{ $data_item->id }}"></i></a>
                <a href="#"><i class="fa fa-trash fa-fw btn-delete-mdl-signatory-item-modal" data-val="{{ $data_item->id }}"></i></a>
            </div>
            
        </div>
    </div>
</div>

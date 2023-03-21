

<div class="col-md-6">
    <div class="card">
    
        <div class="row g-0">
            <div class="col-md-1">
                <img src="{{asset('imgs/user.png')}}" alt="..." class="card-img">
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    @php
                        $detail_page_url = route('fc.batches.show', $data_item->id);
                    @endphp
    
                    <div class="align-items-center">
                        <div><h6 class="card-title"><a href='{{$detail_page_url}}'>{{$data_item->name}}</a></h6></div>
                        <div class="ms-auto"> 
                            <a data-toggle="tooltip" 
                                title="Edit" 
                                data-val='{{$data_item->id}}' 
                                class="btn-edit-mdl-batch-modal inline-block mr-5" href="#">
                                <i class="bx bxs-edit text-warning" style="opacity:80%"></i>
                            </a>
    
                            <a data-toggle="tooltip" 
                                title="Delete" 
                                data-val='{{$data_item->id}}' 
                                class="btn-delete-mdl-batch-modal inline-block mr-5" href="#">
                                <i class="bx bxs-trash-alt text-danger" style="opacity:80%"></i>
                            </a>
                        </div>
                    </div>
                    <p class="card-text">
                        <small class="text-muted">
                            Created: {{ \Carbon\Carbon::parse($data_item->created_at)->format('l jS F Y') }} - {!! \Carbon\Carbon::parse($data_item->created_at)->diffForHumans() !!}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    
    </div>
</div>


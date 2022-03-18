@if ($pageable!=null)

    @php
        $pages = $pageable->pages();
    @endphp


    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-grid mb-2"> 
                        <a href="javascript:;" class="btn btn-sm btn-primary">+ Add Content Page</a>
                    </div>
                    <div class="fm-menu">
                        <div class="list-group list-group-flush"> <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-folder me-2"></i><span>All Files</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-devices me-2"></i><span>My Devices</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-analyse me-2"></i><span>Recents</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Important</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-trash-alt me-2"></i><span>Deleted Files</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-file me-2"></i><span>Documents</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-image me-2"></i><span>Images</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-video me-2"></i><span>Videos</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-music me-2"></i><span>Audio</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-beer me-2"></i><span>Zip Files</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <textarea id="page_contents" name="page_contents" class="summernote"></textarea>
                </div>
            </div>
        </div>
    </div>

    @push('page_css')
    <link rel="stylesheet" href="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.css') }}">
    @endpush

    @push('page_scripts')
    <script src="{{ asset('hasob-foundation-core/assets/summernote-0.8.18-dist/summernote-lite.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        
            $('#page_contents').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']],
                ],
            });    
        });
    </script>
    @endpush

@endif
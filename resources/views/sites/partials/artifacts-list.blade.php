<div class="col-md-12 mb-15">
    <table class="table table-hover mb-0 small">
        <thead>
            <tr>
                <th width="150px" class="p-0"></th>
                <th class="p-0"></th>
                <th width="150px" class="p-0"></th>
            </tr>
        </thead>
        @if (isset($artifacts) && !empty($artifacts) && $artifacts->count() > 0)
            <tbody>
                @foreach ($artifacts as $item)
                    <tr>
                        <td>{{ $item->headline }}</td>
                        <td>{{ $item->content }}</td>
                        <td class="text-end">
                            {{-- 
                            <a href="#" data-val="{{ $item->id }}"
                                data-artifact-type="{{ $item->type }}"
                                class="text-primary btn-site-settings-artifact" 
                                data-bs-toggle="tooltip"
                                title="Settings">
                                <span class="fa fa-cogs me-2"></span>
                            </a> 
                            --}}
                            <a href="#" data-val="{{ $item->id }}"
                                data-artifact-type="{{ $item->type }}"
                                class="text-primary btn-site-edit-artifact btn-edit-mdl-siteArtifact-modal" 
                                data-bs-toggle="tooltip"
                                title="Edit">
                                <span class="fa fa-edit me-2"></span>
                            </a>
                            <a href="#" data-val="{{ $item->id }}"
                                data-artifact-type="{{ $item->type }}"
                                class="text-primary btn-site-delete-artifact btn-delete-mdl-siteArtifact-modal" 
                                data-bs-toggle="tooltip"
                                title="Delete">
                                <span class="fa fa-trash me-2"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <tr>
                <td colspan="2" class="text-danger">
                    No Items
                </td>
            </tr>
        @endif
    </table>
</div>
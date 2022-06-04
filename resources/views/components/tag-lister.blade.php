
@if (isset($taggable) && $taggable != null)
    @php
        $tags = $taggable->tags();
    @endphp
    
    @foreach ($tags as $idx=>$tag)
    <span class="badge rounded-pill bg-info text-dark mx-1 my-1">{{ $tag->name }}</span>
    @endforeach

@endif
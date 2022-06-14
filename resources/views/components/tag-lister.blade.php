
@if (isset($taggable) && $taggable != null)
    @php
        $tags = $taggable->tags();
    @endphp
    
    @foreach ($tags as $idx=>$tag)
        @if($tag != null)
            <span id='span-id' class="badge rounded-pill bg-info text-dark mx-1 my-1">{{ $tag->name }}</span>
        @endif
   
    @endforeach

@endif
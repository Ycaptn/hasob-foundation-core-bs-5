
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
    @foreach ($departments as $item)
    <div class="col">
        <x-hasob-foundation-core::department-badge :department="$item" />
    </div>
    @endforeach
</div>

@include('hasob-foundation-core::departments.modal')
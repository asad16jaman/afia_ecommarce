<div class="category-card">
    <a href="{{ route('category.products', ['slug' => $slug]) }}">
        <div class="category-img">
            <img src="{{ asset($img) }}" class="img-fluid" alt="Party Borka Design">
        </div>
        <h6 class="mt-2 mb-1 fw-bold">{{ $name }}</h6>
    </a>
</div>
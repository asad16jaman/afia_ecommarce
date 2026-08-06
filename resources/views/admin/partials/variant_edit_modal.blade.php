<div class="modal fade" id="editVariantModal{{ $variant->id }}" tabindex="-1"
    aria-labelledby="editVariantLabel{{ $variant->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('products.variants.update', $variant->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Variant - {{ $variant->product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <!-- Size -->
                    <div class="col-md-6">
                        <label for="size_id_{{ $variant->id }}">Size</label>
                        <select name="size_id" class="form-control" id="size_id_{{ $variant->id }}">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}"
                                    {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color -->
                    <div class="col-md-6">
                        <label for="color_id_{{ $variant->id }}">Color</label>
                        <select name="color_id" class="form-control" id="color_id_{{ $variant->id }}">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}"
                                    {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" min="0"
                            value="{{ $variant->stock }}">
                    </div>

                    <!-- Price -->
                    {{-- <div class="col-md-6">
                        <label>Price</label>
                        <input type="number" name="price" step="0.01" class="form-control"
                            value="{{ $variant->price }}">
                    </div> --}}

                    <!-- Discount Price -->
                    {{-- <div class="col-md-6">
                        <label>Discount Price</label>
                        <input type="number" name="discount_price" step="0.01" class="form-control"
                            value="{{ $variant->discount_price }}">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Variant</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

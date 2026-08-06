<div class="modal fade" id="variantModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="variantModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('products.variants.store', $product->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variantModalLabel{{ $product->id }}">
                        Add Variant - {{ $product->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <!-- Size Dropdown -->
                    <div class="col-md-4">
                        <label for="size_id{{ $product->id }}">Size</label>
                        <select name="size_id" class="form-control" id="size_id{{ $product->id }}">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color Dropdown -->
                    <div class="col-md-4">
                        <label for="color_id{{ $product->id }}">Color</label>
                        <select name="color_id" class="form-control" id="color_id{{ $product->id }}">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Stock Input -->
                    <div class="col-md-4">
                        <label>Quantity</label>
                        <input type="number" name="stock" class="form-control" min="1" required>
                    </div>

                    {{-- <div class="col-md-6">
                                                        <label>Price</label>
                                                        <input type="number" name="price" step="0.01" class="form-control" placeholder="Optional">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Discount Price</label>
                                                        <input type="number" name="discount_price" step="0.01" class="form-control" placeholder="Optional">
                                                    </div> --}}

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Variant</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

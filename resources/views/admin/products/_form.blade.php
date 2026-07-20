@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name ?? 'FMAP Magazine') }}"
                           placeholder="Enter product name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                                {{ $category->cat_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price ?? 0) }}"
                                   placeholder="0.00">

                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Publication Date</label>
                            <input type="date"
                                   name="published_at"
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   value="{{ old('published_at', isset($product) && $product->published_at ? $product->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}">

                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="desc"
                              rows="8"
                              class="form-control editor tinymce-editor @error('desc') is-invalid @enderror"
                              placeholder="Enter product description">{{ old('desc', $product->desc ?? '') }}</textarea>

                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Publishing Settings</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="draft" @selected(old('status', $product->status ?? 'draft') === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $product->status ?? '') === 'published')>Published</option>
                        <option value="archived" @selected(old('status', $product->status ?? '') === 'archived')>Archived</option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Competition Status</label>
                    <select name="competition_status" class="form-select @error('competition_status') is-invalid @enderror">
                        <option value="none" @selected(old('competition_status', $product->competition_status ?? 'none') === 'none')>None</option>
                        <option value="active" @selected(old('competition_status', $product->competition_status ?? '') === 'active')>Active</option>
                        <option value="closed" @selected(old('competition_status', $product->competition_status ?? '') === 'closed')>Closed</option>
                    </select>

                    @error('competition_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Media</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Cover Image</label>

                    @if(isset($product) && $product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="img-thumbnail"
                                 style="max-height: 160px;"
                                 alt="{{ $product->name }}">
                        </div>
                    @endif

                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*">

                    <small class="text-muted">Accepted: JPG, PNG, WEBP.</small>

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Magazine / Product File</label>

                    @if(isset($product) && $product->file)
                        <div class="mb-2">
                            <a href="{{ asset('storage/'.$product->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="ri-file-download-line me-1"></i> View Current File
                            </a>
                        </div>
                    @endif

                    <input type="file"
                           name="file"
                           class="form-control @error('file') is-invalid @enderror"
                           accept=".pdf,.doc,.docx">

                    <small class="text-muted">Accepted: PDF, DOC, DOCX.</small>

                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

      
    </div>

    <div class="card">
    <div class="card-header">
        <h5 class="mb-0">Vendor Commission Settings</h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Commission Type</label>

            <select name="commission_type"
                    id="commission_type"
                    class="form-select @error('commission_type') is-invalid @enderror"
                    onchange="toggleCommissionTargetQty()">

                <option value="none"
                    @selected(old('commission_type', $product->commission_type ?? 'none') === 'none')>
                    No Commission
                </option>

                <option value="percentage"
                    @selected(old('commission_type', $product->commission_type ?? '') === 'percentage')>
                    Percentage
                </option>

                <option value="fixed"
                    @selected(old('commission_type', $product->commission_type ?? '') === 'fixed')>
                    Fixed Per Sale
                </option>

                <option value="target_fixed"
                    @selected(old('commission_type', $product->commission_type ?? '') === 'target_fixed')>
                    Target Fixed
                </option>
            </select>

            @error('commission_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Commission Value</label>

            <input type="number"
                   step="0.01"
                   min="0"
                   name="commission_value"
                   class="form-control @error('commission_value') is-invalid @enderror"
                   value="{{ old('commission_value', $product->commission_value ?? 0) }}"
                   placeholder="Example: 10, 500, 2000">

            <small class="text-muted">
                Use 10 for 10%, 500 for ₦500 fixed, or 2000 for target reward.
            </small>

            @error('commission_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3" id="commission_target_qty_box">
            <label class="form-label">Target Quantity</label>

            <input type="number"
                   min="1"
                   name="commission_target_qty"
                   class="form-control @error('commission_target_qty') is-invalid @enderror"
                   value="{{ old('commission_target_qty', $product->commission_target_qty ?? '') }}"
                   placeholder="Example: 20">

            <small class="text-muted">
                Required only for Target Fixed, e.g. sell 20 copies to earn ₦2,000.
            </small>

            @error('commission_target_qty')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">

    <button type="submit" class="btn btn-primary w-50">
        <i class="ri-save-line me-1"></i>
        {{ $buttonText ?? 'Save Product' }}
    </button>

    <a href="{{ route('admin.products.index') }}"
       class="btn btn-light w-50">
        Cancel
    </a>

</div>

    </div>
</div>
</div>

@push("scripts")
    <script>
    function toggleCommissionTargetQty() {
        const commissionType = document.getElementById('commission_type');
        const targetQtyBox = document.getElementById('commission_target_qty_box');

        if (!commissionType || !targetQtyBox) {
            return;
        }

        if (commissionType.value === 'target_fixed') {
            targetQtyBox.style.display = 'block';
        } else {
            targetQtyBox.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', toggleCommissionTargetQty);
</script>
@endpush
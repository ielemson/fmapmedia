@php
    $category = $category ?? null;
@endphp

<div class="row">
    <div class="col-lg-8">

        <div class="mb-3">
            <label class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="cat_name"
                   id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $category->name ?? '') }}"
                   placeholder="e.g. Magazine, Publication, Digital Product">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text"
                   name="slug"
                   id="slug"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $category->slug ?? '') }}"
                   placeholder="Leave empty to auto-generate">

            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      rows="6"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Brief description of this product category">{{ old('description', $category->description ?? '') }}</textarea>

            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="col-lg-4">

        <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="active" {{ old('status', $category->status ?? 'active') === 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ old('status', $category->status ?? '') === 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number"
                   name="sort_order"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $category->sort_order ?? 0) }}">

            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category Image</label>
            <input type="file"
                   name="image"
                   id="image"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/*">

            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="mt-3">
                <img id="imagePreview"
                     src="{{ !empty($category?->image) ? asset($category->image) : asset('backend/assets/images/default-category.jpg') }}"
                     class="img-thumbnail w-100"
                     style="max-height: 180px; object-fit: cover;">
            </div>
        </div>

        <div class="border rounded p-3">
            <div class="form-check form-switch mb-2">
                <input type="checkbox"
                       name="show_on_menu"
                       value="1"
                       class="form-check-input"
                       id="show_on_menu"
                       {{ old('show_on_menu', $category->show_on_menu ?? true) ? 'checked' : '' }}>

                <label class="form-check-label" for="show_on_menu">
                    Show on Menu
                </label>
            </div>

            <div class="form-check form-switch">
                <input type="checkbox"
                       name="show_on_homepage"
                       value="1"
                       class="form-check-input"
                       id="show_on_homepage"
                       {{ old('show_on_homepage', $category->show_on_homepage ?? true) ? 'checked' : '' }}>

                <label class="form-check-label" for="show_on_homepage">
                    Show on Homepage
                </label>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const name = document.getElementById('name');
        const slug = document.getElementById('slug');
        const image = document.getElementById('image');
        const preview = document.getElementById('imagePreview');

        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/&/g, '-and-')
                .replace(/[\s\W-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        if (name && slug) {
            name.addEventListener('keyup', function () {
                if (!slug.value) {
                    slug.value = slugify(name.value);
                }
            });
        }

        if (image && preview) {
            image.addEventListener('change', function (e) {
                const file = e.target.files[0];

                if (file) {
                    preview.src = URL.createObjectURL(file);
                }
            });
        }
    });
</script>
@endpush
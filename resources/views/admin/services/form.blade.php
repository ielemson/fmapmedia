@php
    $editing = isset($service);
@endphp

<div class="row g-4">

    <div class="col-lg-8">

        <div class="card">
            <div class="card-header">
                Service Information
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">
                        Service Title
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title', $service->title ?? '') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           required>

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Slug
                    </label>

                    <input type="text"
                           name="slug"
                           value="{{ old('slug', $service->slug ?? '') }}"
                           class="form-control @error('slug') is-invalid @enderror"
                           placeholder="Generated automatically when empty">

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Short Description
                    </label>

                    <textarea name="short_description"
                              rows="4"
                              maxlength="1000"
                              class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $service->short_description ?? '') }}</textarea>

                    @error('short_description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Full Description
                    </label>

                    <textarea name="description"
                              id="description"
                              rows="12"
                              class="form-control tinymce-editor @error('description') is-invalid @enderror">{{ old('description', $service->description ?? '') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Search Engine Information
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">
                        Meta Title
                    </label>

                    <input type="text"
                           name="meta_title"
                           value="{{ old('meta_title', $service->meta_title ?? '') }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Meta Description
                    </label>

                    <textarea name="meta_description"
                              rows="4"
                              class="form-control">{{ old('meta_description', $service->meta_description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label">
                        Meta Keywords
                    </label>

                    <input type="text"
                           name="meta_keywords"
                           value="{{ old('meta_keywords', $service->meta_keywords ?? '') }}"
                           class="form-control"
                           placeholder="media, publishing, consultancy">
                </div>

            </div>
        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">
            <div class="card-header">
                Service Image
            </div>

            <div class="card-body">

                @if($editing && $service->image)
                    <img src="{{ asset('storage/' . $service->image) }}"
                         alt="{{ $service->title }}"
                         class="img-fluid rounded mb-3">

                    <div class="form-check mb-3">
                        <input type="checkbox"
                               name="remove_image"
                               id="remove_image"
                               value="1"
                               class="form-check-input">

                        <label for="remove_image"
                               class="form-check-label text-danger">
                            Remove current image
                        </label>
                    </div>
                @endif

                <input type="file"
                       name="image"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="form-control @error('image') is-invalid @enderror">

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Maximum size: 3MB.
                </small>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Display Settings
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">
                        Icon Class
                    </label>

                    <input type="text"
                           name="icon"
                           value="{{ old('icon', $service->icon ?? '') }}"
                           class="form-control"
                           placeholder="fas fa-bullhorn">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Display Order
                    </label>

                    <input type="number"
                           name="display_order"
                           min="0"
                           value="{{ old('display_order', $service->display_order ?? 0) }}"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Publication Date
                    </label>

                    <input type="datetime-local"
                           name="published_at"
                           value="{{ old(
                               'published_at',
                               isset($service) && $service->published_at
                                   ? $service->published_at->format('Y-m-d\TH:i')
                                   : ''
                           ) }}"
                           class="form-control">
                </div>

                <div class="form-check form-switch mb-3">

                    <input type="hidden"
                           name="is_active"
                           value="0">

                    <input type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                           class="form-check-input"
                           @checked(old(
                               'is_active',
                               isset($service)
                                   ? $service->is_active
                                   : true
                           ))>

                    <label for="is_active"
                           class="form-check-label">
                        Display on website
                    </label>

                </div>

                <div class="form-check form-switch">

                    <input type="hidden"
                           name="is_featured"
                           value="0">

                    <input type="checkbox"
                           name="is_featured"
                           id="is_featured"
                           value="1"
                           class="form-check-input"
                           @checked(old(
                               'is_featured',
                               $service->is_featured ?? false
                           ))>

                    <label for="is_featured"
                           class="form-check-label">
                        Featured service
                    </label>

                </div>

            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Call to Action
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">
                        Button Text
                    </label>

                    <input type="text"
                           name="button_text"
                           value="{{ old('button_text', $service->button_text ?? '') }}"
                           class="form-control"
                           placeholder="Request Service">
                </div>

                <div>
                    <label class="form-label">
                        Button URL
                    </label>

                    <input type="text"
                           name="button_url"
                           value="{{ old('button_url', $service->button_url ?? '') }}"
                           class="form-control"
                           placeholder="/contact-us">
                </div>

            </div>
        </div>

    </div>

</div>
@php
    $news = $news ?? null;
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">News Content</h4>

                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $news->title ?? '') }}"
                           placeholder="Enter news title">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $news->slug ?? '') }}"
                           placeholder="Leave empty to auto-generate">

                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Summary</label>
                    <textarea name="summary"
                              rows="4"
                              class="form-control @error('summary') is-invalid @enderror"
                              placeholder="Short summary of the news">{{ old('summary', $news->summary ?? '') }}</textarea>

                    @error('summary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Details <span class="text-danger">*</span></label>
                    <textarea name="details"
                              id="details"
                              rows="12"
                              class="form-control editor tinymce-editor @error('details') is-invalid @enderror">{{ old('details', $news->details ?? '') }}</textarea>

                    @error('details')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">SEO Information</h4>

                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text"
                           name="meta_title"
                           class="form-control @error('meta_title') is-invalid @enderror"
                           value="{{ old('meta_title', $news->meta_title ?? '') }}"
                           placeholder="SEO title">

                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description"
                              rows="3"
                              class="form-control @error('meta_description') is-invalid @enderror"
                              placeholder="SEO description">{{ old('meta_description', $news->meta_description ?? '') }}</textarea>

                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-0">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text"
                           name="meta_keywords"
                           class="form-control @error('meta_keywords') is-invalid @enderror"
                           value="{{ old('meta_keywords', $news->meta_keywords ?? '') }}"
                           placeholder="politics, economy, business">

                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">Publish Settings</h4>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $news->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        @foreach(['draft', 'pending', 'published', 'archived'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $news->status ?? 'draft') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                        @foreach([
                            'news' => 'News',
                            'article' => 'Article',
                            'opinion' => 'Opinion',
                            'editorial' => 'Editorial',
                            'interview' => 'Interview',
                            'press_release' => 'Press Release',
                            'video' => 'Video',
                            'photo_news' => 'Photo News',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('type', $news->type ?? 'news') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-0">
                    <label class="form-label">Published Date</label>
                    <input type="datetime-local"
                           name="published_at"
                           class="form-control @error('published_at') is-invalid @enderror"
                           value="{{ old('published_at', !empty($news?->published_at) ? $news->published_at->format('Y-m-d\TH:i') : '') }}" required>

                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">Featured Image</h4>

                <div class="mb-3">
                    <input type="file"
                           name="image"
                           id="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*">

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <img id="imagePreview"
                         src="{{ !empty($news?->image) ? asset($news->image) : asset('backend/assets/images/default-news.jpg') }}"
                         class="img-thumbnail w-100"
                         style="max-height: 220px; object-fit: cover;">
                </div>

                <div class="mb-0">
                    <label class="form-label">Image Caption</label>
                    <input type="text"
                           name="image_caption"
                           class="form-control @error('image_caption') is-invalid @enderror"
                           value="{{ old('image_caption', $news->image_caption ?? '') }}"
                           placeholder="Image caption">

                    @error('image_caption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-3">Editorial Controls</h4>

                @foreach([
                    'featured' => 'Featured',
                    'breaking' => 'Breaking News',
                    'headline' => 'Headline',
                    'trending' => 'Trending',
                    'editors_pick' => "Editor's Pick",
                ] as $field => $label)
                    <div class="form-check form-switch mb-2">
                        <input type="checkbox"
                               name="{{ $field }}"
                               value="1"
                               class="form-check-input"
                               id="{{ $field }}"
                               {{ old($field, $news->$field ?? false) ? 'checked' : '' }}>

                        <label class="form-check-label" for="{{ $field }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>

<div class="row g-4">

    {{-- Event title --}}
    <div class="col-lg-8">
        <label for="title" class="form-label">
            Event Title <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="title"
               id="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $album->title ?? '') }}"
               placeholder="Enter the event or gallery title"
               required>

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Event type --}}
    <div class="col-lg-4">
        <label for="event_type" class="form-label">Event Type</label>

        <input type="text"
               name="event_type"
               id="event_type"
               class="form-control @error('event_type') is-invalid @enderror"
               value="{{ old('event_type', $album->event_type ?? '') }}"
               placeholder="e.g. Award Ceremony">

        @error('event_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Subtitle --}}
    <div class="col-12">
        <label for="subtitle" class="form-label">Subtitle</label>

        <input type="text"
               name="subtitle"
               id="subtitle"
               class="form-control @error('subtitle') is-invalid @enderror"
               value="{{ old('subtitle', $album->subtitle ?? '') }}"
               placeholder="Enter an optional supporting title">

        @error('subtitle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Event date --}}
    <div class="col-lg-3 col-md-6">
        <label for="event_date" class="form-label">Event Date</label>

        <input type="date"
               name="event_date"
               id="event_date"
               class="form-control @error('event_date') is-invalid @enderror"
               value="{{ old(
                   'event_date',
                   isset($album) && $album->event_date
                       ? $album->event_date->format('Y-m-d')
                       : ''
               ) }}">

        @error('event_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- End date --}}
    <div class="col-lg-3 col-md-6">
        <label for="end_date" class="form-label">End Date</label>

        <input type="date"
               name="end_date"
               id="end_date"
               class="form-control @error('end_date') is-invalid @enderror"
               value="{{ old(
                   'end_date',
                   isset($album) && $album->end_date
                       ? $album->end_date->format('Y-m-d')
                       : ''
               ) }}">

        @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Venue --}}
    <div class="col-lg-6">
        <label for="venue" class="form-label">Venue</label>

        <input type="text"
               name="venue"
               id="venue"
               class="form-control @error('venue') is-invalid @enderror"
               value="{{ old('venue', $album->venue ?? '') }}"
               placeholder="Enter the event venue">

        @error('venue')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Location --}}
    <div class="col-lg-6">
        <label for="location" class="form-label">Location</label>

        <input type="text"
               name="location"
               id="location"
               class="form-control @error('location') is-invalid @enderror"
               value="{{ old('location', $album->location ?? '') }}"
               placeholder="e.g. Abuja, Nigeria">

        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Organizer --}}
    <div class="col-lg-6">
        <label for="organizer" class="form-label">Organiser</label>

        <input type="text"
               name="organizer"
               id="organizer"
               class="form-control @error('organizer') is-invalid @enderror"
               value="{{ old('organizer', $album->organizer ?? '') }}"
               placeholder="Enter the organising institution">

        @error('organizer')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Excerpt --}}
    <div class="col-12">
        <label for="excerpt" class="form-label">Short Introduction</label>

        <textarea name="excerpt"
                  id="excerpt"
                  rows="4"
                  class="form-control @error('excerpt') is-invalid @enderror"
                  placeholder="Enter a short summary for the gallery listing">{{ old('excerpt', $album->excerpt ?? '') }}</textarea>

        <div class="form-text">
            This summary will appear on the gallery listing and near the event heading.
        </div>

        @error('excerpt')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Event report --}}
    <div class="col-12">
        <label for="report" class="form-label">Full Event Report</label>

        <textarea name="report"
                  id="report"
                  rows="18"
                  class="form-control tinymce-editor @error('report') is-invalid @enderror"
                  placeholder="Enter the complete event report">{{ old('report', $album->report ?? '') }}</textarea>

        <div class="form-text">
            You may include headings, paragraphs, lists, outcomes, acknowledgements
            and other information relevant to the event.
        </div>

        @error('report')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Cover image --}}
    <div class="col-lg-6">
        <label for="cover_image" class="form-label">
            Cover Image
            @if(!isset($album))
                <span class="text-danger">*</span>
            @endif
        </label>

        <input type="file"
               name="cover_image"
               id="cover_image"
               class="form-control @error('cover_image') is-invalid @enderror"
               accept=".jpg,.jpeg,.png,.webp"
               @required(!isset($album))>

        <div class="form-text">
            Accepted formats: JPG, JPEG, PNG and WebP. Maximum size: 5MB.
        </div>

        @error('cover_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Multiple photographs --}}
    <div class="col-lg-6">
        <label for="images" class="form-label">Gallery Photographs</label>

        <input type="file"
               name="images[]"
               id="images"
               class="form-control @error('images') is-invalid @enderror
                                  @error('images.*') is-invalid @enderror"
               accept=".jpg,.jpeg,.png,.webp"
               multiple>

        <div class="form-text">
            Select multiple photographs. Each photograph must not exceed 5MB.
        </div>

        @error('images')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @error('images.*')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Existing cover image --}}
    @if(isset($album) && $album->cover_image)
        <div class="col-12">
            <label class="form-label">Current Cover Image</label>

            <div>
                <img src="{{ asset('storage/' . $album->cover_image) }}"
                     alt="{{ $album->title }}"
                     class="img-thumbnail"
                     style="width: 180px; height: 120px; object-fit: cover;">
            </div>
        </div>
    @endif

    {{-- Publishing settings --}}
    <div class="col-12">
        <hr>

        <h5 class="mb-3">
            <i class="bi bi-sliders"></i>
            Publishing Settings
        </h5>
    </div>

    <div class="col-lg-3 col-md-6">
        <label for="status" class="form-label">
            Status <span class="text-danger">*</span>
        </label>

        <select name="status"
                id="status"
                class="form-select @error('status') is-invalid @enderror"
                required>

            <option value="draft"
                @selected(old('status', $album->status ?? 'draft') === 'draft')>
                Draft
            </option>

            <option value="published"
                @selected(old('status', $album->status ?? '') === 'published')>
                Published
            </option>

            <option value="archived"
                @selected(old('status', $album->status ?? '') === 'archived')>
                Archived
            </option>
        </select>

        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-3 col-md-6">
        <label for="published_at" class="form-label">Publication Date</label>

        <input type="datetime-local"
               name="published_at"
               id="published_at"
               class="form-control @error('published_at') is-invalid @enderror"
               value="{{ old(
                   'published_at',
                   isset($album) && $album->published_at
                       ? $album->published_at->format('Y-m-d\TH:i')
                       : ''
               ) }}">

        @error('published_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-3 col-md-6">
        <label for="sort_order" class="form-label">Display Order</label>

        <input type="number"
               name="sort_order"
               id="sort_order"
               min="0"
               class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $album->sort_order ?? 0) }}">

        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-lg-3 col-md-6">
        <label class="form-label d-block">Featured Album</label>

        <div class="form-check form-switch mt-2">
            <input type="hidden" name="is_featured" value="0">

            <input type="checkbox"
                   name="is_featured"
                   id="is_featured"
                   class="form-check-input"
                   value="1"
                   @checked(old('is_featured', $album->is_featured ?? false))>

            <label for="is_featured" class="form-check-label">
                Feature this album
            </label>
        </div>

        @error('is_featured')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>
@php
    $editing = isset($teamMember);

    $user = $editing ? $teamMember->user : null;
@endphp

<div class="row g-4">

    {{-- User Information --}}
    <div class="col-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person"></i>
                    User Information
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="first_name" class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="first_name"
                               id="first_name"
                               value="{{ old('first_name', $user?->first_name) }}"
                               class="form-control @error('first_name') is-invalid @enderror"
                               required>

                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">
                            Last Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="last_name"
                               id="last_name"
                               value="{{ old('last_name', $user?->last_name) }}"
                               class="form-control @error('last_name') is-invalid @enderror"
                               required>

                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">
                            Email Address <span class="text-danger">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user?->email) }}"
                               class="form-control @error('email') is-invalid @enderror"
                               required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">
                            Phone Number
                        </label>

                        <input type="text"
                               name="phone"
                               id="phone"
                               value="{{ old('phone', $user?->phone) }}"
                               class="form-control @error('phone') is-invalid @enderror">

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Password
                            @unless($editing)
                                <span class="text-danger">*</span>
                            @endunless
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               {{ $editing ? '' : 'required' }}>

                        @if($editing)
                            <small class="text-muted">
                                Leave blank to retain the current password.
                            </small>
                        @endif

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">
                            Confirm Password
                            @unless($editing)
                                <span class="text-danger">*</span>
                            @endunless
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               {{ $editing ? '' : 'required' }}>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            User Status <span class="text-danger">*</span>
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                            <option value="">Select status</option>

                            <option value="active"
                                @selected(old('status', $user?->status ?? 'active') === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(old('status', $user?->status) === 'inactive')>
                                Inactive
                            </option>

                            <option value="suspended"
                                @selected(old('status', $user?->status) === 'suspended')>
                                Suspended
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Team Profile --}}
    <div class="col-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-badge"></i>
                    Team Profile
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label for="title" class="form-label">
                            Title
                        </label>

                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $teamMember->title ?? '') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Dr., Mr., Mrs., Prof.">

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="position" class="form-label">
                            Position <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="position"
                               id="position"
                               value="{{ old('position', $teamMember->position ?? '') }}"
                               class="form-control @error('position') is-invalid @enderror"
                               placeholder="Founder and Chief Executive Officer"
                               required>

                        @error('position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="department" class="form-label">
                            Department
                        </label>

                        <input type="text"
                               name="department"
                               id="department"
                               value="{{ old('department', $teamMember->department ?? '') }}"
                               class="form-control @error('department') is-invalid @enderror"
                               placeholder="Management, Editorial, ICT">

                        @error('department')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="slug" class="form-label">
                            Profile Slug
                        </label>

                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug', $teamMember->slug ?? '') }}"
                               class="form-control @error('slug') is-invalid @enderror"
                               placeholder="Leave blank to generate automatically">

                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">
                            Profile Image
                        </label>

                        <input type="file"
                               name="image"
                               id="image"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="form-control @error('image') is-invalid @enderror">

                        <small class="text-muted">
                            JPG, PNG or WebP. Maximum size: 2MB.
                        </small>

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @if($editing && $teamMember->image)
                        <div class="col-md-6">
                            <div class="border rounded p-3">

                                <img src="{{ $teamMember->image_url }}"
                                     alt="{{ $teamMember->full_name }}"
                                     width="120"
                                     height="120"
                                     class="rounded border mb-3"
                                     style="object-fit: cover;">

                                <div class="form-check">
                                    <input type="checkbox"
                                           name="remove_image"
                                           id="remove_image"
                                           value="1"
                                           class="form-check-input"
                                           @checked(old('remove_image'))>

                                    <label for="remove_image"
                                           class="form-check-label text-danger">
                                        Remove current image
                                    </label>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <label for="short_bio" class="form-label">
                            Short Biography
                        </label>

                        <textarea name="short_bio"
                                  id="short_bio"
                                  rows="4"
                                  maxlength="1000"
                                  class="form-control @error('short_bio') is-invalid @enderror"
                                  placeholder="A short summary displayed on the team listing page">{{ old('short_bio', $teamMember->short_bio ?? '') }}</textarea>

                        @error('short_bio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="bio" class="form-label">
                            Full Biography
                        </label>

                        <textarea name="bio"
                                  id="bio"
                                  rows="8"
                                  class="form-control tinymce-editor  @error('bio') is-invalid @enderror"
                                  placeholder="Enter the full team member profile">{{ old('bio', $teamMember->bio ?? '') }}</textarea>

                        @error('bio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Professional Details --}}
    <div class="col-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-briefcase"></i>
                    Professional Details
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-5">
                        <label for="qualification" class="form-label">
                            Qualification
                        </label>

                        <input type="text"
                               name="qualification"
                               id="qualification"
                               value="{{ old('qualification', $teamMember->qualification ?? '') }}"
                               class="form-control @error('qualification') is-invalid @enderror"
                               placeholder="PhD, MSc, BSc">

                        @error('qualification')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="specialization" class="form-label">
                            Specialization
                        </label>

                        <input type="text"
                               name="specialization"
                               id="specialization"
                               value="{{ old('specialization', $teamMember->specialization ?? '') }}"
                               class="form-control @error('specialization') is-invalid @enderror">

                        @error('specialization')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="years_of_experience" class="form-label">
                            Experience
                        </label>

                        <input type="number"
                               name="years_of_experience"
                               id="years_of_experience"
                               min="0"
                               max="100"
                               value="{{ old('years_of_experience', $teamMember->years_of_experience ?? '') }}"
                               class="form-control @error('years_of_experience') is-invalid @enderror">

                        @error('years_of_experience')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Social Links --}}
    <div class="col-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-share"></i>
                    Website and Social Links
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    @foreach([
                        'website' => 'Website',
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter / X',
                        'instagram' => 'Instagram',
                        'linkedin' => 'LinkedIn',
                        'youtube' => 'YouTube',
                    ] as $field => $label)

                        <div class="col-md-6">
                            <label for="{{ $field }}" class="form-label">
                                {{ $label }}
                            </label>

                            <input type="url"
                                   name="{{ $field }}"
                                   id="{{ $field }}"
                                   value="{{ old($field, $teamMember->{$field} ?? '') }}"
                                   class="form-control @error($field) is-invalid @enderror"
                                   placeholder="https://">

                            @error($field)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- Display Settings --}}
    <div class="col-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-sliders"></i>
                    Display Settings
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="display_order" class="form-label">
                            Display Order
                        </label>

                        <input type="number"
                               name="display_order"
                               id="display_order"
                               min="0"
                               value="{{ old('display_order', $teamMember->display_order ?? 0) }}"
                               class="form-control @error('display_order') is-invalid @enderror">

                        @error('display_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="published_at" class="form-label">
                            Publication Date
                        </label>

                        <input type="datetime-local"
                               name="published_at"
                               id="published_at"
                               value="{{ old(
                                   'published_at',
                                   isset($teamMember) && $teamMember->published_at
                                       ? $teamMember->published_at->format('Y-m-d\TH:i')
                                       : ''
                               ) }}"
                               class="form-control @error('published_at') is-invalid @enderror">

                        @error('published_at')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">

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
                                           isset($teamMember)
                                               ? $teamMember->is_active
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
                                           $teamMember->is_featured ?? false
                                       ))>

                                <label for="is_featured"
                                       class="form-check-label">
                                    Mark as featured
                                </label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
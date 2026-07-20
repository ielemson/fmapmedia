@php
    $user = $user ?? null;
    $vendor = $vendor ?? null;
    $roles = $roles ?? ['Admin', 'Vendor', 'Customer'];
    $buttonText = $buttonText ?? 'Save User';

    $selectedRole = old('role', $user?->roles?->first()?->name ?? 'Customer');
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name"
               value="{{ old('first_name', $user?->first_name) }}"
               class="form-control @error('first_name') is-invalid @enderror" required>
        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name"
               value="{{ old('last_name', $user?->last_name) }}"
               class="form-control @error('last_name') is-invalid @enderror" required>
        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" name="email"
               value="{{ old('email', $user?->email) }}"
               class="form-control @error('email') is-invalid @enderror" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Password
            @if($user)
                <small class="text-muted">(Leave empty to keep old password)</small>
            @else
                <span class="text-danger">*</span>
            @endif
        </label>

        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               @if(!$user) required @endif>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Role <span class="text-danger">*</span></label>
        <select name="role" id="roleSelect"
                class="form-select @error('role') is-invalid @enderror" required>
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ $selectedRole === $role ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">User Account Status <span class="text-danger">*</span></label>
        <select name="status"
                class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" {{ old('status', $user?->status ?? 'active') === 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="suspended" {{ old('status', $user?->status) === 'suspended' ? 'selected' : '' }}>
                Suspended
            </option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <small class="text-muted">
            This controls whether the user can access the platform.
        </small>
    </div>
</div>

<div id="vendorFields" style="display: none;">
    <hr>

    <h5 class="mb-3">
        <i class="ri-store-2-line me-1"></i> Vendor Information
    </h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Business Name</label>
            <input type="text" name="business_name"
                   value="{{ old('business_name', $vendor?->business_name) }}"
                   class="form-control @error('business_name') is-invalid @enderror">
            @error('business_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Vendor Type</label>
            <select name="vendor_type"
                    class="form-select @error('vendor_type') is-invalid @enderror">
                <option value="">Select Vendor Type</option>
                @foreach(['Individual', 'Business', 'Organization', 'Institution', 'Student Ambassador'] as $type)
                    <option value="{{ $type }}"
                        {{ old('vendor_type', $vendor?->vendor_type) === $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('vendor_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Vendor Approval Status</label>
            <select name="vendor_status"
                    class="form-select @error('vendor_status') is-invalid @enderror">
                @foreach([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'suspended' => 'Suspended',
                ] as $value => $label)
                    <option value="{{ $value }}"
                        {{ old('vendor_status', $vendor?->status ?? 'pending') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('vendor_status') <div class="invalid-feedback">{{ $message }}</div> @enderror

            <small class="text-muted">
                This controls vendor approval separately from user login status.
            </small>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone"
                   value="{{ old('phone', $vendor?->phone) }}"
                   class="form-control @error('phone') is-invalid @enderror">
            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">State</label>
            <input type="text" name="state"
                   value="{{ old('state', $vendor?->state) }}"
                   class="form-control @error('state') is-invalid @enderror">
            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city"
                   value="{{ old('city', $vendor?->city) }}"
                   class="form-control @error('city') is-invalid @enderror">
            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Commission Type</label>
            <select name="commission_type"
                    class="form-select @error('commission_type') is-invalid @enderror">
                <option value="percentage"
                    {{ old('commission_type', $vendor?->commission_type ?? 'percentage') === 'percentage' ? 'selected' : '' }}>
                    Percentage
                </option>
                <option value="fixed"
                    {{ old('commission_type', $vendor?->commission_type) === 'fixed' ? 'selected' : '' }}>
                    Fixed Amount
                </option>
            </select>
            @error('commission_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Commission Value</label>
            <input type="number" step="0.01" min="0" name="commission_value"
                   value="{{ old('commission_value', $vendor?->commission_value ?? 0) }}"
                   class="form-control @error('commission_value') is-invalid @enderror">
            @error('commission_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        @if($vendor)
            <div class="col-md-4 mb-3">
                <label class="form-label">Vendor Code</label>
                <input type="text" value="{{ $vendor->vendor_code ?? 'Pending' }}" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Total Earned</label>
                <input type="text" value="₦{{ number_format($vendor->total_earned ?? 0, 2) }}" class="form-control" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Total Paid</label>
                <input type="text" value="₦{{ number_format($vendor->total_paid ?? 0, 2) }}" class="form-control" readonly>
            </div>
        @endif
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="ri-save-line me-1"></i> {{ $buttonText }}
    </button>

    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        Cancel
    </a>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('roleSelect');
        const vendorFields = document.getElementById('vendorFields');

        if (!roleSelect || !vendorFields) {
            return;
        }

        function toggleVendorFields() {
            vendorFields.style.display = roleSelect.value === 'Vendor' ? 'block' : 'none';
        }

        toggleVendorFields();
        roleSelect.addEventListener('change', toggleVendorFields);
    });
</script>
@endpush
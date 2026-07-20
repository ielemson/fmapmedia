<form method="POST" action="{{ route('vendor.register.store') }}">
    @csrf

    <div class="row">

        <!-- Full Name -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-user-2-line auti-custom-input-icon"></i>
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Business Name -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-building-line auti-custom-input-icon"></i>
                <label for="business_name">Business / Brand Name</label>
                <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}"
                    class="form-control @error('business_name') is-invalid @enderror"
                    placeholder="Business or Brand Name" required>

                @error('business_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-mail-line auti-custom-input-icon"></i>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" required>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Phone -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-phone-line auti-custom-input-icon"></i>
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number" required>

                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Vendor Type -->
        <div class="col-md-6">
            <div class="mb-4">
                <label for="vendor_type">Vendor Type</label>

                <select name="vendor_type" id="vendor_type"
                    class="form-control @error('vendor_type') is-invalid @enderror" required>

                    <option value="">Select Vendor Type</option>
                    <option value="Individual">Individual</option>
                    <option value="Business">Business</option>
                    <option value="Organization">Organization</option>
                    <option value="Institution">Institution</option>
                    <option value="Student Ambassador">Student Ambassador
                    </option>

                </select>

                @error('vendor_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- State -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-map-pin-line auti-custom-input-icon"></i>
                <label for="state">State</label>
                <input type="text" name="state" id="state" value="{{ old('state') }}"
                    class="form-control @error('state') is-invalid @enderror" placeholder="Enter State" required>

                @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- City -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-map-pin-2-line auti-custom-input-icon"></i>
                <label for="city">City</label>
                <input type="text" name="city" id="city" value="{{ old('city') }}"
                    class="form-control @error('city') is-invalid @enderror" placeholder="Enter City" required>

                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-lock-2-line auti-custom-input-icon"></i>
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6">
            <div class="auth-form-group-custom mb-4">
                <i class="ri-lock-password-line auti-custom-input-icon"></i>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="Confirm Password" required>
            </div>
        </div>
<div class="col-md-6">
    <div class="mb-4">
        <label>
            Security Check:
            What is <strong>{{ $a }} + {{ $b }}</strong> ?
        </label>

        <input
            type="number"
            name="captcha"
            class="form-control @error('captcha') is-invalid @enderror"
            required
        >

        @error('captcha')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
        <!-- Terms -->
        <div class="col-md-12">
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>

                <label class="form-check-label" for="terms">
                    I agree to the Vendor Terms & Conditions and understand that
                    my application will be reviewed before approval.
                </label>
            </div>
        </div>

        <!-- Button -->
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary px-5 waves-effect waves-light">
                Register as Vendor
            </button>
        </div>

    </div>
</form>

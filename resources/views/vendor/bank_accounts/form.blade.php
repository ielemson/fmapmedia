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

<form action="{{ $action }}" method="POST">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">
                        <i class="bi bi-bank2 text-primary me-2"></i>
                        Bank Account Details
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="bank_name"
                               class="form-control @error('bank_name') is-invalid @enderror"
                               value="{{ old('bank_name', $bankAccount->bank_name ?? '') }}"
                               placeholder="Example: Access Bank">

                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="account_name"
                               class="form-control @error('account_name') is-invalid @enderror"
                               value="{{ old('account_name', $bankAccount->account_name ?? '') }}"
                               placeholder="Account holder name">

                        @error('account_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Number <span class="text-danger">*</span></label>
                        <input type="text"
                               name="account_number"
                               class="form-control @error('account_number') is-invalid @enderror"
                               value="{{ old('account_number', $bankAccount->account_number ?? '') }}"
                               placeholder="10-digit account number">

                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bank Code</label>
                        <input type="text"
                               name="bank_code"
                               class="form-control @error('bank_code') is-invalid @enderror"
                               value="{{ old('bank_code', $bankAccount->bank_code ?? '') }}"
                               placeholder="Optional">

                        @error('bank_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input type="checkbox"
                               name="is_default"
                               value="1"
                               class="form-check-input"
                               id="is_default"
                               @checked(old('is_default', $bankAccount->is_default ?? false))>

                        <label class="form-check-label" for="is_default">
                            Set as default payout account
                        </label>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6>Payout Notice</h6>
                    <p class="text-muted small mb-0">
                        Ensure your account name and number are correct. FMAP Media will use your default account for commission payouts.
                    </p>
                </div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    {{ $buttonText }}
                </button>

                <a href="{{ route('vendor.bank-accounts.index') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
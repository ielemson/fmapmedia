@extends("admin.layout.app")

@section("title", "Add User")

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">User Management</span>

        <h1>Add New User</h1>

        <p>
            Create a new FMAP Media account and assign the appropriate role such as Admin, Vendor, or Customer.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back to Users
        </a>
    </div>
</div>

@include('frontend.partials.alert')

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            @include('admin.users._form', [
                'user' => null,
                'vendor' => null,
                'roles' => $roles,
                'buttonText' => 'Create User'
            ])
        </form>
    </div>
</div>

@endsection
@extends("admin.layout.app")

@section("title", "Edit User")

@section("main-content")
 <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">User Management</span>

            <h1>Edit User</h1>

            <p>
                Update user information, assign roles, manage vendor details, and control account access within FMAP Media.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Users
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.users._form', [
                    'user' => $user,
                    'vendor' => $user->vendor,
                    'roles' => $roles,
                    'buttonText' => 'Update User'
                ])

            </form>

        </div>
    </div>


@endsection
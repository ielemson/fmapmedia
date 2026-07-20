@extends("admin.layout.app")

@section("title", "User Management")

@section("main-content")

   <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">User Management</span>

            <h1>Users</h1>

            <p>
                Manage administrators, vendors, customers, user access, and account status across FMAP Media.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i>
                Add User
            </a>
        </div>
    </div>

    @include("frontend.partials.alert")

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
               <table class="table table-bordered table-hover align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            {{-- <th>Vendor Business</th> --}}
            <th>User Status</th>
            <th>Vendor Status</th>
            <th width="240">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $key => $user)
            <tr>
                <td>{{ $users->firstItem() + $key }}</td>

                <td>
                    <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                </td>

                <td>{{ $user->email }}</td>

                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-info">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </td>

                {{-- <td>
                    {{ $user->vendor?->business_name ?? 'N/A' }}
                </td> --}}

                <td>
                    @if($user->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Suspended</span>
                    @endif
                </td>

                <td>
                    @if($user->hasRole('Vendor'))
                        @switch($user->vendor?->status)
                            @case('approved')
                                <span class="badge bg-success">Approved</span>
                                @break

                            @case('pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @break

                            @case('rejected')
                                <span class="badge bg-danger">Rejected</span>
                                @break

                            @case('suspended')
                                <span class="badge bg-secondary">Suspended</span>
                                @break

                            @default
                                <span class="badge bg-light text-dark">Unknown</span>
                        @endswitch
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    @if($user->status === 'active')
                        <form action="{{ route('admin.users.suspend', $user->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    onclick="return confirm('Suspend this user?')"
                                    class="btn btn-sm btn-warning">
                                Suspend
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.activate', $user->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-sm btn-success">
                                Activate
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Delete this user permanently?')"
                                class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    No users found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>

@endsection
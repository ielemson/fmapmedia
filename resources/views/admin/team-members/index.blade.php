@extends('admin.layout.app')

@section('title', 'Team Management')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Team Management</span>

            <h1>Team Members</h1>

            <p>
                Manage FMAP Media team profiles, positions, departments,
                publication status, and display order.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.team-members.create') }}"
               class="btn btn-primary">
                <i class="bi bi-person-plus"></i>
                Add Team Member
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <div class="card">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.team-members.index') }}"
                  class="row g-3 mb-4">

                <div class="col-lg-5 col-md-7">
                    <label for="search" class="form-label">
                        Search Team Members
                    </label>

                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search by name, email, position or department">
                </div>

                <div class="col-lg-3 col-md-5 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                        Search
                    </button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.team-members.index') }}"
                           class="btn btn-light">
                            Reset
                        </a>
                    @endif
                </div>

            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="70">#</th>
                            <th>Team Member</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>User Status</th>
                            <th>Profile Status</th>
                            <th>Featured</th>
                            <th>Order</th>
                            <th width="190">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($teamMembers as $key => $teamMember)
                            <tr>
                                <td>
                                    {{ $teamMembers->firstItem() + $key }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div>
                                            <img src="{{ $teamMember->image_url }}"
                                                 alt="{{ $teamMember->full_name }}"
                                                 width="55"
                                                 height="55"
                                                 class="rounded-circle border"
                                                 style="object-fit: cover;">
                                        </div>

                                        <div>
                                            <strong class="d-block">
                                                {{ $teamMember->full_name }}
                                            </strong>

                                            <small class="text-muted">
                                                {{ $teamMember->user?->email }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    {{ $teamMember->position }}
                                </td>

                                <td>
                                    @if($teamMember->department)
                                        <span class="badge bg-info">
                                            {{ $teamMember->department }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <td>
                                    @switch($teamMember->user?->status)
                                        @case('active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                            @break

                                        @case('inactive')
                                            <span class="badge bg-secondary">
                                                Inactive
                                            </span>
                                            @break

                                        @case('suspended')
                                            <span class="badge bg-danger">
                                                Suspended
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-light text-dark">
                                                Unknown
                                            </span>
                                    @endswitch
                                </td>

                                <td>
                                    @if($teamMember->is_active)
                                        <span class="badge bg-success">
                                            Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Hidden
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($teamMember->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            Featured
                                        </span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $teamMember->display_order }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.team-members.show', $teamMember) }}"
                                       class="btn btn-sm btn-info"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.team-members.edit', $teamMember) }}"
                                       class="btn btn-sm btn-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.team-members.destroy', $teamMember) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                                onclick="return confirm('Remove this team member profile? The user account will remain active.')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-people fs-1 d-block mb-2"></i>

                                    No team members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if($teamMembers->hasPages())
                <div class="mt-4">
                    {{ $teamMembers->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection
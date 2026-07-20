@extends('admin.layout.app')

@section('title', 'Services Management')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">
                Services Management
            </span>

            <h1>Our Services</h1>

            <p>
                Manage FMAP Media services, descriptions, images,
                publication settings and display order.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.services.create') }}"
               class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add Service
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <div class="card mb-4">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.services.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Search</label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Search services...">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>

                            <option value="active"
                                @selected(request('status') === 'active')>
                                Active
                            </option>

                            <option value="inactive"
                                @selected(request('status') === 'inactive')>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Sort</label>

                        <select name="sort" class="form-select">
                            <option value="latest"
                                @selected(request('sort', 'latest') === 'latest')>
                                Latest
                            </option>

                            <option value="oldest"
                                @selected(request('sort') === 'oldest')>
                                Oldest
                            </option>

                            <option value="title"
                                @selected(request('sort') === 'title')>
                                Title
                            </option>

                            <option value="order"
                                @selected(request('sort') === 'order')>
                                Display Order
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-primary flex-fill">
                                Filter
                            </button>

                            <a href="{{ route('admin.services.index') }}"
                               class="btn btn-light">
                                Reset
                            </a>

                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('admin.services.index', ['status' => 'active']) }}"
                   class="btn btn-sm btn-outline-success">
                    <i class="bi bi-check-circle"></i>
                    Active
                </a>

                <a href="{{ route('admin.services.index', ['status' => 'inactive']) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-eye-slash"></i>
                    Inactive
                </a>

                <a href="{{ route('admin.services.index', ['featured' => 1]) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-star"></i>
                    Featured
                </a>

            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h5 class="mb-1">Service Records</h5>

                    <p class="text-muted mb-0">
                        Showing {{ $services->firstItem() ?? 0 }}
                        -
                        {{ $services->lastItem() ?? 0 }}
                        of {{ $services->total() }} records
                    </p>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="80">Image</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Order</th>
                            <th>Published</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($services as $service)
                            <tr>

                                <td>
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}"
                                             alt="{{ $service->title }}"
                                             style="width:60px;height:50px;object-fit:cover;border-radius:8px;">
                                    @elseif($service->icon)
                                        <div class="text-center fs-3 text-primary">
                                            <i class="{{ $service->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="text-center fs-3 text-muted">
                                            <i class="bi bi-briefcase"></i>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <strong>
                                        {{ $service->title }}
                                    </strong>

                                    @if($service->short_description)
                                        <small class="d-block text-muted mt-1">
                                            {{ Str::limit(
                                                $service->short_description,
                                                90
                                            ) }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    @if($service->is_active)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($service->is_featured)
                                        <span class="badge bg-primary">
                                            Featured
                                        </span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $service->display_order }}
                                </td>

                                <td>
                                    {{ $service->published_at?->format('d M Y') ?? 'Immediately' }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.services.show', $service) }}"
                                       class="btn btn-sm btn-light">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.services.destroy', $service) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this service?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-briefcase display-5 d-block mb-2"></i>

                                    No services found.

                                    <div class="mt-3">
                                        <a href="{{ route('admin.services.create') }}"
                                           class="btn btn-primary">
                                            Add Service
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($services->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $services->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection
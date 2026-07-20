@extends("vendor.layout.app")

@section("main-header")
    @include("vendor.partials.mainsidebar")
@endsection

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Notifications</span>

        <h1>My Notifications</h1>

        <p>
            View sales, commission, withdrawal, approval and account updates
            related to your FMAP Media vendor account.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        @if(auth()->user()->unreadNotifications->count())
            <form action="{{ route('vendor.notifications.readAll') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-all"></i>
                    Mark All Read
                </button>
            </form>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>
    </div>
</div>

@include("frontend.partials.alert")

<section class="section">
    <h5 class="section-title mb-3">Notification Overview</h5>

    <div class="row g-4">

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bell fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format(auth()->user()->notifications()->count()) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Total Notifications
                        </p>
                    </div>

                    <span class="badge bg-primary">All</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-warning text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-bell-fill fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format(auth()->user()->unreadNotifications()->count()) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Unread Notifications
                        </p>
                    </div>

                    <span class="badge bg-warning text-dark">Unread</span>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">
                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-check2-circle fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ number_format(auth()->user()->readNotifications()->count()) }}
                        </h6>
                        <p class="widget-user-location mb-0">
                            Read Notifications
                        </p>
                    </div>

                    <span class="badge bg-success">Read</span>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="section mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0">
            <h5 class="mb-0">
                <i class="bi bi-bell text-primary me-2"></i>
                Notification Records
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="70">#</th>
                            <th>Notification</th>
                            <th width="120">Type</th>
                            <th width="140">Status</th>
                            <th width="180">Date</th>
                            <th class="text-end" width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($notifications as $key => $notification)

                            @php
                                $type = $notification->data['type'] ?? 'info';

                                $icon = match($type) {
                                    'success' => 'bi-check-circle-fill',
                                    'warning' => 'bi-exclamation-triangle-fill',
                                    'danger'  => 'bi-x-circle-fill',
                                    default   => 'bi-info-circle-fill',
                                };

                                $badge = match($type) {
                                    'success' => 'bg-success',
                                    'warning' => 'bg-warning text-dark',
                                    'danger'  => 'bg-danger',
                                    default   => 'bg-info',
                                };
                            @endphp

                            <tr class="{{ is_null($notification->read_at) ? 'table-warning' : '' }}">
                                <td>{{ $notifications->firstItem() + $key }}</td>

                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 mt-1">
                                            <i class="bi {{ $icon }} fs-4"></i>
                                        </div>

                                        <div>
                                            <h6 class="mb-1">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </h6>

                                            <small class="text-muted">
                                                {{ $notification->data['message'] ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge {{ $badge }}">
                                        {{ ucfirst($type) }}
                                    </span>
                                </td>

                                <td>
                                    @if(is_null($notification->read_at))
                                        <span class="badge bg-warning text-dark">Unread</span>
                                    @else
                                        <span class="badge bg-success">Read</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $notification->created_at->format('d M, Y') }}
                                    <small class="d-block text-muted">
                                        {{ $notification->created_at->format('h:i A') }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('vendor.notifications.show', $notification->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-bell-slash display-5 d-block mb-2"></i>
                                    No notification record yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>

        </div>
    </div>
</section>

@endsection
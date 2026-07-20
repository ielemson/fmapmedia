@extends("admin.layout.app")

@section("title", "Notifications")

@section("main-content")

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Notification Center</span>

        <h1>Notifications</h1>

        <p>
            View system alerts, withdrawal requests, vendor approvals,
            orders, commissions, and other administrative activities
            across FMAP Media.
        </p>
    </div>

    <div class="dashboard-hero-actions">

        @if(auth()->user()->unreadNotifications->count())
            <form action="{{ route('admin.notifications.readAll') }}"
                  method="POST">
                @csrf

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-all"></i>
                    Mark All Read
                </button>
            </form>
        @endif

    </div>
</div>

@include("frontend.partials.alert")

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead>
                    <tr>
                        <th width="70">#</th>
                        <th>Notification</th>
                        <th width="120">Type</th>
                        <th width="180">Status</th>
                        <th width="180">Date</th>
                        <th class="text-end" width="140">Action</th>
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
                            default   => 'bi-info-circle-fill'
                        };

                        $badge = match($type) {
                            'success' => 'bg-success',
                            'warning' => 'bg-warning text-dark',
                            'danger'  => 'bg-danger',
                            default   => 'bg-info'
                        };
                    @endphp

                    <tr class="{{ is_null($notification->read_at) ? 'table-warning' : '' }}">

                        <td>
                            {{ $notifications->firstItem() + $key }}
                        </td>

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
                                <span class="badge bg-warning text-dark">
                                    Unread
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Read
                                </span>

                                <div class="small text-muted mt-1">
                                    {{ $notification->read_at->diffForHumans() }}
                                </div>
                            @endif
                        </td>

                        <td>
                            {{ $notification->created_at->format('M d, Y') }}
                            <br>

                            <small class="text-muted">
                                {{ $notification->created_at->format('h:i A') }}
                            </small>
                        </td>

                        <td class="text-end">

                            @if(!empty($notification->data['url']))
                                <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">

                            <i class="bi bi-bell display-5 d-block mb-2"></i>

                            No notifications found.

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

@endsection
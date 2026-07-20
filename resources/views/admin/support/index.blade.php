@extends('admin.layout.app')

@section('main-header')
    @include('admin.partials.mainsidebar')
@endsection

@section('main-content')

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Support Management</span>

        <h1>Vendor Support Tickets</h1>

        <p>
            Review vendor complaints, assign support officers, respond to enquiries
            and monitor ticket resolution across the FMAP Media platform.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('dashboard') }}"
           class="btn btn-light">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<section class="section">
    <h5 class="section-title mb-3">
        Support Overview
    </h5>

    <div class="row g-4">

        <div class="col-xl-3 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">

                    <div class="widget-user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-ticket-perforated fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ $statistics['total'] ?? 0 }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            Total Tickets
                        </p>
                    </div>

                    <span class="badge bg-primary">
                        All
                    </span>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">

                    <div class="widget-user-avatar bg-warning text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-envelope-open fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ $statistics['open'] ?? 0 }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            Open Tickets
                        </p>
                    </div>

                    <span class="badge bg-warning text-dark">
                        Open
                    </span>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">

                    <div class="widget-user-avatar bg-info text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ $statistics['in_progress'] ?? 0 }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            In Progress
                        </p>
                    </div>

                    <span class="badge bg-info text-dark">
                        Active
                    </span>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">

                    <div class="widget-user-avatar bg-danger text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ $statistics['urgent'] ?? 0 }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            Urgent Tickets
                        </p>
                    </div>

                    <span class="badge bg-danger">
                        Urgent
                    </span>

                </div>
            </div>
        </div>

    </div>
</section>

<section class="section mt-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-transparent border-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <h5 class="mb-0">
                    <i class="bi bi-headset text-primary me-2"></i>
                    Support Ticket Management
                </h5>

                <span class="badge bg-light text-dark">
                    {{ $tickets->total() }} Ticket(s)
                </span>

            </div>
        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.support.index') }}"
                  class="mb-4">

                <div class="row g-3">

                    <div class="col-xl-4 col-md-6">
                        <label class="form-label">
                            Search
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Ticket number, subject or vendor">
                    </div>

                    <div class="col-xl-2 col-md-6">
                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>

                            <option value="open"
                                @selected(request('status') === 'open')>
                                Open
                            </option>

                            <option value="in_progress"
                                @selected(request('status') === 'in_progress')>
                                In Progress
                            </option>

                            <option value="waiting_vendor"
                                @selected(request('status') === 'waiting_vendor')>
                                Waiting for Vendor
                            </option>

                            <option value="resolved"
                                @selected(request('status') === 'resolved')>
                                Resolved
                            </option>

                            <option value="closed"
                                @selected(request('status') === 'closed')>
                                Closed
                            </option>
                        </select>
                    </div>

                    <div class="col-xl-2 col-md-6">
                        <label class="form-label">
                            Priority
                        </label>

                        <select name="priority" class="form-select">
                            <option value="">All Priorities</option>

                            <option value="low"
                                @selected(request('priority') === 'low')>
                                Low
                            </option>

                            <option value="medium"
                                @selected(request('priority') === 'medium')>
                                Medium
                            </option>

                            <option value="high"
                                @selected(request('priority') === 'high')>
                                High
                            </option>

                            <option value="urgent"
                                @selected(request('priority') === 'urgent')>
                                Urgent
                            </option>
                        </select>
                    </div>

                    <div class="col-xl-2 col-md-6">
                        <label class="form-label">
                            Category
                        </label>

                        <select name="category" class="form-select">
                            <option value="">All Categories</option>

                            <option value="account"
                                @selected(request('category') === 'account')>
                                Account
                            </option>

                            <option value="commission"
                                @selected(request('category') === 'commission')>
                                Commission
                            </option>

                            <option value="withdrawal"
                                @selected(request('category') === 'withdrawal')>
                                Withdrawal
                            </option>

                            <option value="payment"
                                @selected(request('category') === 'payment')>
                                Payment
                            </option>

                            <option value="referral"
                                @selected(request('category') === 'referral')>
                                Referral
                            </option>

                            <option value="technical"
                                @selected(request('category') === 'technical')>
                                Technical
                            </option>

                            <option value="magazine"
                                @selected(request('category') === 'magazine')>
                                Magazine
                            </option>

                            <option value="other"
                                @selected(request('category') === 'other')>
                                Other
                            </option>
                        </select>
                    </div>

                    <div class="col-xl-2 col-md-6 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.support.index') }}"
                           class="btn btn-light">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Vendor</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Last Activity</th>
                        <th width="100">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($tickets as $ticket)

                        <tr>

                            <td>
                                <strong>
                                    {{ $ticket->ticket_number }}
                                </strong>

                                <small class="d-block text-muted">
                                    {{ $ticket->created_at->format('d M, Y') }}
                                </small>
                            </td>

                            <td>
                                <strong>
                                    {{ $ticket->vendor?->business_name ?? 'N/A' }}
                                </strong>

                                <small class="d-block text-muted">
                                    {{ $ticket->user?->name ?? 'Unknown Vendor' }}
                                </small>
                            </td>

                            <td>
                                <strong>
                                    {{ Str::limit($ticket->subject, 45) }}
                                </strong>

                                <small class="d-block text-muted">
                                    {{ Str::limit($ticket->message, 60) }}
                                </small>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($ticket->category) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $ticket->priority_class }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $ticket->status_class }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>

                            <td>
                                @if($ticket->assignedAdmin)
                                    <strong>
                                        {{ $ticket->assignedAdmin->name }}
                                    </strong>
                                @else
                                    <span class="text-muted">
                                        Unassigned
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $ticket->last_reply_at?->diffForHumans()
                                    ?? $ticket->updated_at->diffForHumans() }}

                                <small class="d-block text-muted">
                                    {{ $ticket->public_replies_count ?? 0 }} replies
                                </small>
                            </td>

                            <td>
                                <a href="{{ route('admin.support.show', $ticket) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>
                                    View
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9"
                                class="text-center text-muted py-5">

                                <i class="bi bi-headset display-5 d-block mb-3"></i>

                                <h6>No support tickets found</h6>

                                <p class="mb-0">
                                    Vendor support tickets will appear here.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $tickets->links() }}
            </div>

        </div>

    </div>

</section>

@endsection
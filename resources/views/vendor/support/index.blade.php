@extends('vendor.layout.app')

@section('main-header')
    @include('vendor.partials.mainsidebar')
@endsection

@section('main-content')

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">Vendor Support Center</span>

        <h1>Support Tickets</h1>

        <p>
            Raise tickets for technical issues, payment concerns, withdrawal problems,
            referral disputes or any assistance you may need from the FMAP Media team.
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('vendor.support.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Ticket
        </a>

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
                        <i class="bi bi-hourglass-split fs-4"></i>
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

                    <span class="badge bg-info">
                        Active
                    </span>

                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card widget-user-card-horizontal">
                <div class="card-body">

                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>

                    <div class="widget-user-info">
                        <h6 class="widget-user-name">
                            {{ $statistics['resolved'] ?? 0 }}
                        </h6>

                        <p class="widget-user-location mb-0">
                            Resolved
                        </p>
                    </div>

                    <span class="badge bg-success">
                        Done
                    </span>

                </div>
            </div>
        </div>

    </div>

</section>


<section class="section mt-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-headset text-primary me-2"></i>
                Ticket History
            </h5>

            <a href="{{ route('vendor.support.create') }}"
               class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                New Ticket
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Replies</th>
                        <th>Created</th>
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
                            </td>

                            <td>
                                <strong>
                                    {{ $ticket->subject }}
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
                                {{ $ticket->public_replies_count }}
                            </td>

                            <td>
                                {{ $ticket->created_at->format('d M, Y') }}

                                <small class="d-block text-muted">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </small>
                            </td>

                            <td>
                                <a href="{{ route('vendor.support.show', $ticket) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="text-center text-muted py-5">

                                <i class="bi bi-headset display-5 d-block mb-3"></i>

                                <h6>
                                    No support ticket found
                                </h6>

                                <p>
                                    Need help? Create your first support ticket.
                                </p>

                                <a href="{{ route('vendor.support.create') }}"
                                   class="btn btn-primary">
                                    Create Ticket
                                </a>

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
@extends('vendor.layout.app')

@section('main-header')
    @include('vendor.partials.mainsidebar')
@endsection

@section('main-content')

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">
            Support Ticket
        </span>

        <h1>{{ $supportTicket->ticket_number }}</h1>

        <p>
            {{ $supportTicket->subject }}
        </p>
    </div>

    <div class="dashboard-hero-actions">

        <a href="{{ route('vendor.support.index') }}"
           class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back to Tickets
        </a>

        @if($supportTicket->status === 'closed')
            <form method="POST"
                  action="{{ route('vendor.support.reopen', $supportTicket) }}">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reopen Ticket
                </button>
            </form>
        @elseif($supportTicket->status !== 'resolved')
            <form method="POST"
                  action="{{ route('vendor.support.close', $supportTicket) }}"
                  onsubmit="return confirm('Are you sure you want to close this ticket?');">

                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-x-circle"></i>
                    Close Ticket
                </button>
            </form>
        @endif

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

<div class="row g-4">

    <div class="col-xl-8">

        <section class="section">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent border-0 d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-chat-left-text text-primary me-2"></i>
                            Ticket Conversation
                        </h5>

                        <small class="text-muted">
                            Created {{ $supportTicket->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <span class="badge {{ $supportTicket->status_class }}">
                        {{ $supportTicket->status_label }}
                    </span>

                </div>

                <div class="card-body">

                    {{-- Original ticket message --}}
                    <div class="border rounded p-3 mb-4 bg-light">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                     style="width: 42px; height: 42px;">
                                    <i class="bi bi-person"></i>
                                </div>

                                <div>
                                    <h6 class="mb-0">
                                        {{ $supportTicket->user?->name ?? auth()->user()->first_name }}
                                    </h6>

                                    <small class="text-muted">
                                        Vendor
                                    </small>
                                </div>

                            </div>

                            <small class="text-muted">
                                {{ $supportTicket->created_at->format('d M, Y h:i A') }}
                            </small>

                        </div>

                        <p class="mb-3" style="white-space: pre-line;">
                            {{ $supportTicket->message }}
                        </p>

                        @if($supportTicket->attachment)
                            <div class="border-top pt-3">
                                <a href="{{ Storage::url($supportTicket->attachment) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-paperclip me-1"></i>
                                    View Attachment
                                </a>
                            </div>
                        @endif

                    </div>

                    {{-- Ticket replies --}}
                    @forelse($supportTicket->publicReplies as $reply)

                        <div class="border rounded p-3 mb-4
                            {{ $reply->is_admin_reply ? 'border-primary' : 'bg-light' }}">

                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="rounded-circle
                                        {{ $reply->is_admin_reply ? 'bg-success' : 'bg-primary' }}
                                        text-white d-flex align-items-center justify-content-center"
                                         style="width: 42px; height: 42px;">

                                        @if($reply->is_admin_reply)
                                            <i class="bi bi-headset"></i>
                                        @else
                                            <i class="bi bi-person"></i>
                                        @endif

                                    </div>

                                    <div>
                                        <h6 class="mb-0">
                                            {{ $reply->user?->name ?? 'Support User' }}
                                        </h6>

                                        <small class="text-muted">
                                            {{ $reply->is_admin_reply ? 'FMAP Media Support' : 'Vendor' }}
                                        </small>
                                    </div>

                                </div>

                                <small class="text-muted">
                                    {{ $reply->created_at->format('d M, Y h:i A') }}
                                </small>

                            </div>

                            <p class="mb-3" style="white-space: pre-line;">
                                {{ $reply->message }}
                            </p>

                            @if($reply->attachment)
                                <div class="border-top pt-3">
                                    <a href="{{ Storage::url($reply->attachment) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-paperclip me-1"></i>
                                        View Attachment
                                    </a>
                                </div>
                            @endif

                        </div>

                    @empty

                        <div class="text-center text-muted py-4">
                            <i class="bi bi-chat-dots display-6 d-block mb-2"></i>

                            <h6>No replies yet</h6>

                            <p class="mb-0">
                                The support team has not replied to this ticket yet.
                            </p>
                        </div>

                    @endforelse

                </div>
            </div>

            {{-- Reply form --}}
            @if($supportTicket->status !== 'closed')

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-reply text-primary me-2"></i>
                            Add Reply
                        </h5>
                    </div>

                    <div class="card-body">

                        @if($supportTicket->status === 'resolved')
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-1"></i>
                                This ticket has been marked as resolved. Adding a reply will reopen it.
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('vendor.support.reply', $supportTicket) }}"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="mb-3">
                                <label for="message" class="form-label">
                                    Your Reply
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea id="message"
                                          name="message"
                                          rows="6"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Enter your reply..."
                                          required>{{ old('message') }}</textarea>

                                @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label">
                                    Attachment
                                    <span class="text-muted">(Optional)</span>
                                </label>

                                <input type="file"
                                       id="attachment"
                                       name="attachment"
                                       class="form-control @error('attachment') is-invalid @enderror"
                                       accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx">

                                @error('attachment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small class="text-muted">
                                    Maximum file size: 5MB.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Send Reply
                            </button>

                        </form>

                    </div>
                </div>

            @else

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <i class="bi bi-lock display-5 text-muted"></i>

                        <h5 class="mt-3">
                            This ticket is closed
                        </h5>

                        <p class="text-muted">
                            Reopen the ticket before adding another reply.
                        </p>

                        <form method="POST"
                              action="{{ route('vendor.support.reopen', $supportTicket) }}">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reopen Ticket
                            </button>

                        </form>

                    </div>
                </div>

            @endif

        </section>

    </div>

    <div class="col-xl-4">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Ticket Details
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Ticket Number
                    </small>

                    <strong>
                        {{ $supportTicket->ticket_number }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Subject
                    </small>

                    <strong>
                        {{ $supportTicket->subject }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Category
                    </small>

                    <span class="badge bg-light text-dark">
                        {{ ucfirst($supportTicket->category) }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Priority
                    </small>

                    <span class="badge {{ $supportTicket->priority_class }}">
                        {{ ucfirst($supportTicket->priority) }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Status
                    </small>

                    <span class="badge {{ $supportTicket->status_class }}">
                        {{ $supportTicket->status_label }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Assigned Support Officer
                    </small>

                    <strong>
                        {{ $supportTicket->assignedAdmin?->name ?? 'Not assigned yet' }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Created
                    </small>

                    <strong>
                        {{ $supportTicket->created_at->format('d M, Y h:i A') }}
                    </strong>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Last Activity
                    </small>

                    <strong>
                        {{ $supportTicket->last_reply_at?->diffForHumans() ?? $supportTicket->updated_at->diffForHumans() }}
                    </strong>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex align-items-start gap-3">

                    <div class="widget-user-avatar bg-success text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>

                    <div>
                        <h6 class="mb-1">
                            Support Communication
                        </h6>

                        <p class="text-muted small mb-0">
                            Keep all information about this issue within the ticket conversation
                            so the support team can follow the complete history.
                        </p>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@endsection
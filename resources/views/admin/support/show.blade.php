@extends('admin.layout.app')

@section('main-header')
    @include('admin.partials.mainsidebar')
@endsection

@section('main-content')

<div class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-eyebrow">
            Support Ticket Management
        </span>

        <h1>{{ $supportTicket->ticket_number }}</h1>

        <p>
            {{ $supportTicket->subject }}
        </p>
    </div>

    <div class="dashboard-hero-actions">
        <a href="{{ route('admin.support.index') }}"
           class="btn btn-light">
            <i class="bi bi-arrow-left"></i>
            Back to Tickets
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

<div class="row g-4">

    <div class="col-xl-8">

        <section class="section">

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent border-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div>
                            <h5 class="mb-1">
                                <i class="bi bi-chat-left-text text-primary me-2"></i>
                                Ticket Conversation
                            </h5>

                            <small class="text-muted">
                                Opened {{ $supportTicket->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <span class="badge {{ $supportTicket->priority_class }}">
                                {{ ucfirst($supportTicket->priority) }}
                            </span>

                            <span class="badge {{ $supportTicket->status_class }}">
                                {{ $supportTicket->status_label }}
                            </span>
                        </div>

                    </div>
                </div>

                <div class="card-body">

                    {{-- Original vendor message --}}
                    <div class="border rounded p-3 mb-4 bg-light">

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                            <div class="d-flex align-items-center gap-2">

                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                     style="width: 44px; height: 44px;">
                                    <i class="bi bi-person"></i>
                                </div>

                                <div>
                                    <h6 class="mb-0">
                                        {{ $supportTicket->user?->name ?? 'Vendor' }}
                                    </h6>

                                    <small class="text-muted">
                                        {{ $supportTicket->vendor?->business_name ?? 'Vendor Account' }}
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

                    {{-- Replies --}}
                    @forelse($supportTicket->replies as $reply)

                        @if($reply->is_internal_note)

                            <div class="border border-warning rounded p-3 mb-4 bg-warning bg-opacity-10">

                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center"
                                             style="width: 44px; height: 44px;">
                                            <i class="bi bi-sticky"></i>
                                        </div>

                                        <div>
                                            <h6 class="mb-0">
                                                {{ $reply->user?->name ?? 'Administrator' }}
                                            </h6>

                                            <small class="text-warning-emphasis">
                                                Internal Note
                                            </small>
                                        </div>

                                    </div>

                                    <small class="text-muted">
                                        {{ $reply->created_at->format('d M, Y h:i A') }}
                                    </small>

                                </div>

                                <p class="mb-0" style="white-space: pre-line;">
                                    {{ $reply->message }}
                                </p>

                            </div>

                        @else

                            <div class="border rounded p-3 mb-4
                                {{ $reply->is_admin_reply ? 'border-success' : 'bg-light' }}">

                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="rounded-circle
                                            {{ $reply->is_admin_reply ? 'bg-success' : 'bg-primary' }}
                                            text-white d-flex align-items-center justify-content-center"
                                             style="width: 44px; height: 44px;">

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
                                                {{ $reply->is_admin_reply
                                                    ? 'FMAP Media Support'
                                                    : 'Vendor' }}
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

                        @endif

                    @empty

                        <div class="text-center text-muted py-4">

                            <i class="bi bi-chat-dots display-6 d-block mb-2"></i>

                            <h6>No replies yet</h6>

                            <p class="mb-0">
                                This ticket has not received a reply.
                            </p>

                        </div>

                    @endforelse

                </div>
            </div>

            @if($supportTicket->status !== 'closed')

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-transparent border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-reply text-primary me-2"></i>
                            Add Response
                        </h5>
                    </div>

                    <div class="card-body">

                        <form method="POST"
                              action="{{ route('admin.support.reply', $supportTicket) }}"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="mb-3">
                                <label for="message" class="form-label">
                                    Response
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea id="message"
                                          name="message"
                                          rows="6"
                                          class="form-control @error('message') is-invalid @enderror"
                                          placeholder="Enter your response..."
                                          required>{{ old('message') }}
                                </textarea>

                                @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row g-3">

                                <div class="col-md-7">
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
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">
                                        Response Type
                                    </label>

                                    <div class="border rounded p-2">

                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="is_internal_note"
                                                   id="public_reply"
                                                   value="0"
                                                   @checked(old('is_internal_note', '0') === '0')>

                                            <label class="form-check-label"
                                                   for="public_reply">
                                                Public reply
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="is_internal_note"
                                                   id="internal_note"
                                                   value="1"
                                                   @checked(old('is_internal_note') === '1')>

                                            <label class="form-check-label"
                                                   for="internal_note">
                                                Internal note
                                            </label>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-4">

                                <button type="submit"
                                        class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i>
                                    Send Response
                                </button>

                            </div>

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

                        <p class="text-muted mb-0">
                            Change the status before adding another response.
                        </p>

                    </div>
                </div>

            @endif

        </section>

    </div>

    <div class="col-xl-4">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="bi bi-sliders text-primary me-2"></i>
                    Ticket Controls
                </h5>
            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('admin.support.status', $supportTicket) }}"
                      class="mb-4">

                    @csrf
                    @method('PATCH')

                    <label for="status" class="form-label">
                        Ticket Status
                    </label>

                    <div class="input-group">

                        <select id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror">

                            <option value="open"
                                @selected($supportTicket->status === 'open')>
                                Open
                            </option>

                            <option value="in_progress"
                                @selected($supportTicket->status === 'in_progress')>
                                In Progress
                            </option>

                            <option value="waiting_vendor"
                                @selected($supportTicket->status === 'waiting_vendor')>
                                Waiting for Vendor
                            </option>

                            <option value="resolved"
                                @selected($supportTicket->status === 'resolved')>
                                Resolved
                            </option>

                            <option value="closed"
                                @selected($supportTicket->status === 'closed')>
                                Closed
                            </option>

                        </select>

                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>

                    </div>

                    @error('status')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </form>

                <form method="POST"
                      action="{{ route('admin.support.priority', $supportTicket) }}"
                      class="mb-4">

                    @csrf
                    @method('PATCH')

                    <label for="priority" class="form-label">
                        Ticket Priority
                    </label>

                    <div class="input-group">

                        <select id="priority"
                                name="priority"
                                class="form-select @error('priority') is-invalid @enderror">

                            <option value="low"
                                @selected($supportTicket->priority === 'low')>
                                Low
                            </option>

                            <option value="medium"
                                @selected($supportTicket->priority === 'medium')>
                                Medium
                            </option>

                            <option value="high"
                                @selected($supportTicket->priority === 'high')>
                                High
                            </option>

                            <option value="urgent"
                                @selected($supportTicket->priority === 'urgent')>
                                Urgent
                            </option>

                        </select>

                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>

                    </div>

                    @error('priority')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </form>

                <form method="POST"
                      action="{{ route('admin.support.assign', $supportTicket) }}">

                    @csrf
                    @method('PATCH')

                    <label for="assigned_to" class="form-label">
                        Assign Support Officer
                    </label>

                    <div class="input-group">

                        <select id="assigned_to"
                                name="assigned_to"
                                class="form-select @error('assigned_to') is-invalid @enderror">

                            <option value="">
                                Unassigned
                            </option>

                            @foreach($administrators as $administrator)
                                <option value="{{ $administrator->id }}"
                                    @selected(
                                        old(
                                            'assigned_to',
                                            $supportTicket->assigned_to
                                        ) == $administrator->id
                                    )>

                                    {{ $administrator->name }}

                                </option>
                            @endforeach

                        </select>

                        <button type="submit"
                                class="btn btn-primary">
                            Assign
                        </button>

                    </div>

                    @error('assigned_to')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </form>

            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Ticket Information
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
                        Category
                    </small>

                    <span class="badge bg-light text-dark">
                        {{ ucfirst($supportTicket->category) }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Created
                    </small>

                    <strong>
                        {{ $supportTicket->created_at->format('d M, Y h:i A') }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Last Activity
                    </small>

                    <strong>
                        {{ $supportTicket->last_reply_at?->diffForHumans()
                            ?? $supportTicket->updated_at->diffForHumans() }}
                    </strong>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Total Replies
                    </small>

                    <strong>
                        {{ $supportTicket->replies->count() }}
                    </strong>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0">
                    <i class="bi bi-shop text-success me-2"></i>
                    Vendor Information
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Vendor Name
                    </small>

                    <strong>
                        {{ $supportTicket->user?->name ?? 'N/A' }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Business Name
                    </small>

                    <strong>
                        {{ $supportTicket->vendor?->business_name ?? 'N/A' }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Email Address
                    </small>

                    <strong>
                        {{ $supportTicket->user?->email ?? 'N/A' }}
                    </strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Phone Number
                    </small>

                    <strong>
                        {{ $supportTicket->vendor?->phone ?? 'N/A' }}
                    </strong>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Vendor Code
                    </small>

                    <strong>
                        {{ $supportTicket->vendor?->vendor_code ?? 'N/A' }}
                    </strong>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection
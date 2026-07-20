@extends('admin.layout.app')

@section('title', 'Team Member Profile')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Team Management</span>

            <h1>Team Member Profile</h1>

            <p>
                View the account and public profile information for
                {{ $teamMember->full_name }}.
            </p>
        </div>

        <div class="dashboard-hero-actions">

            <a href="{{ route('admin.team-members.edit', $teamMember) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </a>

            <a href="{{ route('admin.team-members.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Team
            </a>

        </div>
    </div>

    @include('frontend.partials.alert')

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card">
                <div class="card-body text-center">

                    <img src="{{ $teamMember->image_url }}"
                         alt="{{ $teamMember->full_name }}"
                         width="180"
                         height="180"
                         class="rounded-circle border mb-3"
                         style="object-fit: cover;">

                    <h3 class="mb-1">
                        {{ $teamMember->full_name }}
                    </h3>

                    <p class="text-primary fw-semibold mb-1">
                        {{ $teamMember->position }}
                    </p>

                    <p class="text-muted">
                        {{ $teamMember->department ?? 'No department assigned' }}
                    </p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">

                        @if($teamMember->is_active)
                            <span class="badge bg-success">
                                Published
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Hidden
                            </span>
                        @endif

                        @if($teamMember->is_featured)
                            <span class="badge bg-warning text-dark">
                                Featured
                            </span>
                        @endif

                        @switch($teamMember->user?->status)
                            @case('active')
                                <span class="badge bg-success">
                                    Active User
                                </span>
                                @break

                            @case('inactive')
                                <span class="badge bg-secondary">
                                    Inactive User
                                </span>
                                @break

                            @case('suspended')
                                <span class="badge bg-danger">
                                    Suspended User
                                </span>
                                @break
                        @endswitch

                    </div>

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Contact Information
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Email Address
                        </small>

                        <a href="mailto:{{ $teamMember->user?->email }}">
                            {{ $teamMember->user?->email }}
                        </a>
                    </div>

                    <div>
                        <small class="text-muted d-block">
                            Phone Number
                        </small>

                        @if($teamMember->user?->phone)
                            <a href="tel:{{ $teamMember->user->phone }}">
                                {{ $teamMember->user->phone }}
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">
                <div class="card-header">
                    Profile Information
                </div>

                <div class="card-body">

                    <table class="table table-bordered align-middle mb-0">

                        <tr>
                            <th width="240">Profile Slug</th>
                            <td>{{ $teamMember->slug }}</td>
                        </tr>

                        <tr>
                            <th>Position</th>
                            <td>{{ $teamMember->position }}</td>
                        </tr>

                        <tr>
                            <th>Department</th>
                            <td>{{ $teamMember->department ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Qualification</th>
                            <td>{{ $teamMember->qualification ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Specialization</th>
                            <td>{{ $teamMember->specialization ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Years of Experience</th>
                            <td>
                                @if(!is_null($teamMember->years_of_experience))
                                    {{ $teamMember->years_of_experience }}
                                    {{ Str::plural('year', $teamMember->years_of_experience) }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Display Order</th>
                            <td>{{ $teamMember->display_order }}</td>
                        </tr>

                        <tr>
                            <th>Publication Date</th>
                            <td>
                                {{ $teamMember->published_at?->format('d M Y, h:i A') ?? 'Immediately' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Created</th>
                            <td>
                                {{ $teamMember->created_at?->format('d M Y, h:i A') }}
                            </td>
                        </tr>

                    </table>

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Short Biography
                </div>

                <div class="card-body">
                    @if($teamMember->short_bio)
                        <p class="mb-0">
                            {!! nl2br(e($teamMember->short_bio)) !!}
                        </p>
                    @else
                        <p class="text-muted mb-0">
                            No short biography provided.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Full Biography
                </div>

                <div class="card-body">
                    @if($teamMember->bio)
                        <div>
                            {!! nl2br(e($teamMember->bio)) !!}
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No full biography provided.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Website and Social Links
                </div>

                <div class="card-body">

                    @php
                        $socialLinks = [
                            'website' => ['label' => 'Website', 'icon' => 'bi-globe'],
                            'facebook' => ['label' => 'Facebook', 'icon' => 'bi-facebook'],
                            'twitter' => ['label' => 'Twitter / X', 'icon' => 'bi-twitter-x'],
                            'instagram' => ['label' => 'Instagram', 'icon' => 'bi-instagram'],
                            'linkedin' => ['label' => 'LinkedIn', 'icon' => 'bi-linkedin'],
                            'youtube' => ['label' => 'YouTube', 'icon' => 'bi-youtube'],
                        ];
                    @endphp

                    <div class="row g-3">

                        @forelse($socialLinks as $field => $details)
                            @if($teamMember->{$field})
                                <div class="col-md-6">
                                    <a href="{{ $teamMember->{$field} }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-outline-primary w-100 text-start">

                                        <i class="bi {{ $details['icon'] }} me-2"></i>

                                        {{ $details['label'] }}
                                    </a>
                                </div>
                            @endif
                        @empty
                        @endforelse

                        @if(
                            !$teamMember->website &&
                            !$teamMember->facebook &&
                            !$teamMember->twitter &&
                            !$teamMember->instagram &&
                            !$teamMember->linkedin &&
                            !$teamMember->youtube
                        )
                            <div class="col-12">
                                <p class="text-muted mb-0">
                                    No website or social media links provided.
                                </p>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

            <div class="card mt-4 border-danger">
                <div class="card-header text-danger">
                    Remove Team Profile
                </div>

                <div class="card-body">

                    <p>
                        Removing this team profile will not delete the associated
                        user account.
                    </p>

                    <form action="{{ route('admin.team-members.destroy', $teamMember) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('Remove this team member profile?')">

                            <i class="bi bi-trash"></i>
                            Remove Team Member
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

@endsection
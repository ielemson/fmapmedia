@extends('admin.layout.app')

@section('title', 'Edit Team Member')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Team Management</span>

            <h1>Edit Team Member</h1>

            <p>
                Update {{ $teamMember->full_name }}'s account and public profile.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.team-members.show', $teamMember) }}"
               class="btn btn-info">
                <i class="bi bi-eye"></i>
                View Profile
            </a>

            <a href="{{ route('admin.team-members.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Team
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.team-members.update', $teamMember) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.team-members.form')

        <div class="card mt-4">
            <div class="card-body d-flex justify-content-end gap-2">

                <a href="{{ route('admin.team-members.index') }}"
                   class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Update Team Member
                </button>

            </div>
        </div>

    </form>

@endsection
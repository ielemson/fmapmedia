@extends('admin.layout.app')

@section('title', 'Add Team Member')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">Team Management</span>

            <h1>Add Team Member</h1>

            <p>
                Create a new user account and assign a public team profile.
            </p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.team-members.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back to Team
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.team-members.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @include('admin.team-members.form')

        <div class="card mt-4">
            <div class="card-body d-flex justify-content-end gap-2">

                <a href="{{ route('admin.team-members.index') }}"
                   class="btn btn-light">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Save Team Member
                </button>

            </div>
        </div>

    </form>

@endsection
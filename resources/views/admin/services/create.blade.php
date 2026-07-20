@extends('admin.layout.app')

@section('title', 'Add Service')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">
                Services Management
            </span>

            <h1>Add Service</h1>

            <p>Create a new service for the FMAP Media website.</p>
        </div>

        <div class="dashboard-hero-actions">
            <a href="{{ route('admin.services.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    @include('frontend.partials.alert')

    <form action="{{ route('admin.services.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        @include('admin.services.form')

        <div class="card mt-4">
            <div class="card-body text-end">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Save Service
                </button>

            </div>
        </div>

    </form>

@endsection
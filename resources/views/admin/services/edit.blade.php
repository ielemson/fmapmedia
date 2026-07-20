@extends('admin.layout.app')

@section('title', 'Edit Service')

@section('main-content')

    <div class="dashboard-hero">
        <div class="dashboard-hero-copy">
            <span class="dashboard-eyebrow">
                Services Management
            </span>

            <h1>Edit Service</h1>

            <p>Update {{ $service->title }}.</p>
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

    <form action="{{ route('admin.services.update', $service) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.services.form')

        <div class="card mt-4">
            <div class="card-body text-end">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Update Service
                </button>

            </div>
        </div>

    </form>

@endsection
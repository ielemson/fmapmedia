@extends('layouts.app')

@section('title', 'Home | FutureMap Media')
@section("header")
@include('frontend.partials.header') 
{{-- @include('frontend.partials.contact-sidebar') --}}
{{-- @include('frontend.partials.subscribe-modal') --}}
@endsection

@section('content')

    {{-- Slider --}}
    @include('frontend.sections.home-slider')

    {{-- About --}}
    @include('frontend.sections.about')

    @include('frontend.sections.features')

    {{-- Services --}}
    {{-- @include('frontend.sections.services') --}}

    {{-- Magazines --}}
    @include('frontend.sections.magazines')

        {{-- Testimonials --}}
    @include('frontend.sections.packages')

    {{-- Featured Vendors --}}
    {{-- @include('frontend.sections.vendors') --}}



    {{-- News --}}
    @include('frontend.sections.news')

    {{-- Contact --}}
    @include('frontend.sections.contact')

@endsection
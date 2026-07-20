@extends('layouts.app')

@section('title', 'Home | FutureMap Media')

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', ['header' => 'Contact Us'])

    {{-- Contact Information --}}
    <section class="content-inner">

        <div class="container">

            <div class="section-head style-1 text-center">

                <h6 class="sub-title text-primary">
                    Contact Information
                </h6>

                <h2 class="title">
                    We Would Love to Hear From You
                </h2>

                <p class="mx-auto" style="max-width: 750px;">
                    Contact FutureMap Media Concepts Limited for enquiries about
                    our media services, educational programmes, e-commerce
                    solutions, magazine publications and strategic partnerships.
                </p>

            </div>

            <div class="row justify-content-center">

                {{-- Phone --}}
                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">

                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="01">

                        <div class="icon-md m-r20">

                            <span class="icon-cell text-primary">
                                <i class="flaticon-telephone"></i>
                            </span>

                        </div>

                        <div class="icon-content">

                            <h4 class="title m-b10">
                                Call Us
                            </h4>

                            <p class="m-b0">

                                <a href="tel:+2348035082149">
                                    0803 508 2149
                                </a>

                                <br>

                                <a href="tel:+2347062990717">
                                    0706 299 0717
                                </a>

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Email --}}
                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800"
                    data-aos-delay="400">

                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="02">

                        <div class="icon-md m-r20">

                            <span class="icon-cell text-primary">
                                <i class="flaticon-email"></i>
                            </span>

                        </div>

                        <div class="icon-content">

                            <h4 class="title m-b10">
                                Email Us
                            </h4>

                            <p class="m-b0">

                                <a href="mailto:fmap-abuja@fmapmedia.com">
                                    fmap-abuja@fmapmedia.com
                                </a>

                                <br>

                                <a href="mailto:info@fmapmedia.com">
                                    info@fmapmedia.com
                                </a>

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Location --}}
                <div class="col-lg-4 col-md-12 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800"
                    data-aos-delay="600">

                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="03">

                        <div class="icon-md m-r20">

                            <span class="icon-cell text-primary">
                                <i class="flaticon-placeholder"></i>
                            </span>

                        </div>

                        <div class="icon-content">

                            <h4 class="title m-b10">
                                Visit Our Office
                            </h4>

                            <p class="m-b0">
                                Suite B11(4), Real Tower Center,<br>
                                No. 26 A. E. Ekukinam Street,<br>
                                Utako, Abuja, Nigeria.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- Map and Contact Form --}}
    <section class="content-inner-1 pt-0">

        {{-- Google Map --}}
        <div class="map-iframe">

            <iframe
                src="https://www.google.com/maps?q=Real%20Tower%20Center%20No%2026%20A%20E%20Ekukinam%20Street%20Utako%20Abuja&output=embed"
                class="align-self-stretch radius-sm" style="border: 0; width: 100%; min-height: 450px;" loading="lazy"
                allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="FutureMap Media Abuja Office Location">
            </iframe>

        </div>


        <div class="container">

            <div class="contact-area1 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">

                <div class="section-head style-1 text-center">

                    <h6 class="sub-title text-primary">
                        Send Us a Message
                    </h6>

                    <h2 class="title">
                        Let’s Start a Conversation
                    </h2>

                    <p>
                        Complete the form below and a member of our team will
                        respond to your enquiry.
                    </p>

                </div>


                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <i class="fas fa-check-circle me-2"></i>

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>

                    </div>
                @endif


                {{-- General Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">

                        <strong>
                            Please correct the following:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                <form id="contactForm" class="dz-form style-1" method="POST" action="{{ route('contact.store') }}"
                    data-parsley-validate novalidate>

                    @csrf

                    <div class="row sp10">

                        {{-- First Name --}}
                        <div class="col-sm-6 m-b20">

                            <div class="input-group">
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    placeholder="First Name" autocomplete="given-name" maxlength="50" required
                                    data-parsley-required-message="Please enter your first name." data-parsley-minlength="2"
                                    data-parsley-minlength-message="Your first name must contain at least 2 characters."
                                    data-parsley-errors-container="#first_name_error">
                            </div>

                            <div id="first_name_error" class="field-error-container"></div>

                        </div>


                        {{-- Last Name --}}
                        <div class="col-sm-6 m-b20">

                            <div class="input-group">
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    placeholder="Last Name" autocomplete="family-name" maxlength="50" required
                                    data-parsley-required-message="Please enter your last name."
                                    data-parsley-minlength="2"
                                    data-parsley-minlength-message="Your last name must contain at least 2 characters."
                                    data-parsley-errors-container="#last_name_error">
                            </div>

                            <div id="last_name_error" class="field-error-container"></div>

                        </div>


                        {{-- Email --}}
                        <div class="col-sm-6 m-b20">

                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Email Address" autocomplete="email" maxlength="150" required
                                    data-parsley-required-message="Please enter your email address."
                                    data-parsley-type-message="Please enter a valid email address."
                                    data-parsley-errors-container="#email_error">
                            </div>

                            <div id="email_error" class="field-error-container"></div>

                        </div>


                        {{-- Phone --}}
                        <div class="col-sm-6 m-b20">

                            <div class="input-group">
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    placeholder="Phone Number" autocomplete="tel" maxlength="30"
                                    data-parsley-pattern="^[0-9+\-\s()]+$"
                                    data-parsley-pattern-message="Please enter a valid phone number."
                                    data-parsley-errors-container="#phone_error">
                            </div>

                            <div id="phone_error" class="field-error-container"></div>

                        </div>


                        {{-- Subject --}}
                        <div class="col-sm-12 m-b20">

                            <div class="input-group">
                                <input type="text" name="subject" id="subject" class="form-control"
                                    placeholder="Subject" maxlength="150" required
                                    data-parsley-required-message="Please enter the subject of your enquiry."
                                    data-parsley-minlength="3"
                                    data-parsley-minlength-message="The subject must contain at least 3 characters."
                                    data-parsley-errors-container="#subject_error">
                            </div>

                            <div id="subject_error" class="field-error-container"></div>

                        </div>


                        {{-- Message --}}
                        <div class="col-sm-12 m-b20">

                            <div class="input-group">
                                <textarea name="message" id="message" rows="6" class="form-control"
                                    placeholder="Write your message here..." maxlength="5000" required
                                    data-parsley-required-message="Please write your message." data-parsley-minlength="10"
                                    data-parsley-minlength-message="Your message must contain at least 10 characters."
                                    data-parsley-errors-container="#message_error"></textarea>
                            </div>

                            <div id="message_error" class="field-error-container"></div>

                        </div>

                        {{-- Session CAPTCHA --}}
<div class="col-sm-12 m-b20">

    <label for="captcha_answer" class="form-label">
        Security Question
    </label>

    <div class="input-group">

        <span
            class="input-group-text"
            id="captchaQuestion"
            style="min-width: 110px; justify-content: center; font-weight: 600;"
        >
            Loading...
        </span>

        <input
            type="number"
            name="captcha_answer"
            id="captcha_answer"
            class="form-control"
            placeholder="Enter the answer"
            inputmode="numeric"
            autocomplete="off"
            min="0"
            max="100"
            required
            data-parsley-required-message="Please answer the security question."
            data-parsley-type="integer"
            data-parsley-type-message="Please enter a valid number."
            data-parsley-errors-container="#captcha_answer_error"
        >

        <button
            type="button"
            id="refreshCaptcha"
            class="btn btn-outline-secondary"
            title="Generate another question"
            aria-label="Generate another security question"
        >
            <i class="fas fa-sync-alt"></i>
        </button>

    </div>

    <small class="form-text text-muted">
        Please solve the simple calculation above.
    </small>

    <div
        id="captcha_answer_error"
        class="field-error-container"
    ></div>

</div>

                        {{-- Honeypot --}}
                        <div class="d-none" aria-hidden="true">

                            <label for="website">
                                Leave this field empty
                            </label>

                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">

                        </div>


                        {{-- Submit --}}
                        <div class="col-sm-12 text-center">

                            <button type="submit" id="contactSubmitButton" class="btn btn-primary btn-rounded">

                                <span class="submit-text">
                                    Send Message
                                </span>

                                <span class="submit-loader d-none">
                                    Sending...
                                </span>

                                <i class="submit-icon m-l10 fas fa-paper-plane"></i>

                                <span class="spinner-border spinner-border-sm m-l10 d-none" role="status"
                                    aria-hidden="true"></span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>
@endsection

@push('scripts')
    {{-- Parsley Validation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    $(function() {
        const $form = $('#contactForm');
        const $submitButton = $('#contactSubmitButton');
        const $captchaQuestion = $('#captchaQuestion');
        const $captchaInput = $('#captcha_answer');
        const $refreshCaptchaButton = $('#refreshCaptcha');

        const captchaUrl = @json(route('contact.captcha'));

        const parsleyForm = $form.parsley({
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorsWrapper: '<div class="invalid-feedback d-block"></div>',
            errorTemplate: '<span></span>',
            trigger: 'change focusout'
        });

        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,
            positionClass: 'toast-top-right',
            timeOut: 6000,
            extendedTimeOut: 2000
        };

        /**
         * Load a fresh CAPTCHA question.
         */
        function loadCaptcha(showError = true) {
            $captchaQuestion.text('Loading...');
            $captchaInput.val('');

            $refreshCaptchaButton
                .prop('disabled', true)
                .find('i')
                .addClass('fa-spin');

            return $.ajax({
                url: captchaUrl,
                method: 'GET',
                dataType: 'json',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                success: function(response) {
                    if (response.success && response.question) {
                        $captchaQuestion.text(response.question + ' =');
                        return;
                    }

                    $captchaQuestion.text('Unavailable');
                },

                error: function() {
                    $captchaQuestion.text('Try again');

                    if (showError) {
                        toastr.error(
                            'The security question could not be generated.',
                            'CAPTCHA Error'
                        );
                    }
                },

                complete: function() {
                    $refreshCaptchaButton
                        .prop('disabled', false)
                        .find('i')
                        .removeClass('fa-spin');
                }
            });
        }

        /**
         * Refresh CAPTCHA manually.
         */
        $refreshCaptchaButton.on('click', function() {
            loadCaptcha();

            parsleyForm
                .fields
                .find(field => field.$element.attr('name') === 'captcha_answer')
                ?.reset();

            $('#captcha_answer_error')
                .find('.server-validation-error')
                .remove();

            $captchaInput
                .removeClass(
                    'is-invalid is-valid server-invalid parsley-error parsley-success'
                );
        });

        /**
         * Remove Laravel server-validation errors.
         */
        function clearServerErrors() {
            $form.find('.server-validation-error').remove();

            $form.find('.form-control')
                .removeClass('is-invalid server-invalid');
        }

        /**
         * Display loading state.
         */
        function setSubmitting(isSubmitting) {
            $submitButton.prop('disabled', isSubmitting);

            $submitButton.find('.submit-text')
                .toggleClass('d-none', isSubmitting);

            $submitButton.find('.submit-loader')
                .toggleClass('d-none', !isSubmitting);

            $submitButton.find('.submit-icon')
                .toggleClass('d-none', isSubmitting);

            $submitButton.find('.spinner-border')
                .toggleClass('d-none', !isSubmitting);
        }

        /**
         * Add Laravel validation errors beneath each field.
         */
        function displayServerErrors(errors) {
            Object.entries(errors).forEach(function([field, messages]) {
                const $field = $form.find(`[name="${field}"]`);
                const $errorContainer = $(`#${field}_error`);

                if (!$field.length) {
                    return;
                }

                $field.addClass('is-invalid server-invalid');

                const message = Array.isArray(messages)
                    ? messages[0]
                    : messages;

                const $error = $('<div>', {
                    class: 'invalid-feedback d-block server-validation-error',
                    text: message
                });

                if ($errorContainer.length) {
                    $errorContainer
                        .find('.server-validation-error')
                        .remove();

                    $errorContainer.append($error);
                } else {
                    $field.closest('.input-group').after($error);
                }
            });

            const firstInvalidField = $form
                .find('.server-invalid')
                .first();

            if (firstInvalidField.length) {
                $('html, body').animate({
                    scrollTop: firstInvalidField.offset().top - 150
                }, 400);

                firstInvalidField.trigger('focus');
            }
        }

        /**
         * Remove an individual server error when the field changes.
         */
        $form.on('input change', '.form-control', function() {
            const fieldName = $(this).attr('name');

            $(this).removeClass('server-invalid');

            $(`#${fieldName}_error`)
                .find('.server-validation-error')
                .remove();

            if (
                !$(this).hasClass('parsley-error') &&
                !$(`#${fieldName}_error .invalid-feedback`).length
            ) {
                $(this).removeClass('is-invalid');
            }
        });

        /**
         * AJAX contact submission.
         */
        $form.on('submit', function(event) {
            event.preventDefault();

            clearServerErrors();

            if (!parsleyForm.validate()) {
                toastr.warning(
                    'Please correct the highlighted fields before sending your message.',
                    'Check the Form'
                );

                return;
            }

            setSubmitting(true);

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },

                success: function(response) {
                    toastr.success(
                        response.message ||
                        'Your message has been sent successfully.',
                        'Message Sent'
                    );

                    $form[0].reset();
                    parsleyForm.reset();

                    $form.find('.form-control')
                        .removeClass(
                            'is-valid is-invalid parsley-success parsley-error'
                        );

                    clearServerErrors();

                    /*
                     * Generate another CAPTCHA because the previous one
                     * has been removed from the session.
                     */
                    loadCaptcha(false);
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors || {};

                        displayServerErrors(errors);

                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Please correct the highlighted fields.',
                            'Validation Failed'
                        );

                        /*
                         * The controller invalidates the CAPTCHA after
                         * every unsuccessful submission.
                         */
                        loadCaptcha(false);

                        return;
                    }

                    if (xhr.status === 429) {
                        toastr.warning(
                            'You have submitted too many messages. Please wait briefly before trying again.',
                            'Too Many Requests'
                        );

                        loadCaptcha(false);

                        return;
                    }

                    toastr.error(
                        xhr.responseJSON?.message ||
                        'We could not send your message. Please try again.',
                        'Submission Failed'
                    );

                    loadCaptcha(false);
                },

                complete: function() {
                    setSubmitting(false);
                }
            });
        });

        /**
         * Generate the initial CAPTCHA when the page loads.
         */
        loadCaptcha(false);
    });
</script>
@endpush

@push('styles')
    <style>
        .field-error-container {
            width: 100%;
            margin-top: 5px;
        }

        .field-error-container .invalid-feedback {
            display: block;
            margin: 0;
            font-size: 13px;
            line-height: 1.4;
        }

        .dz-form .form-control.is-invalid,
        .dz-form .form-control.parsley-error {
            border-color: #dc3545 !important;
            box-shadow: none;
        }

        .dz-form .form-control.is-valid,
        .dz-form .form-control.parsley-success {
            border-color: #198754 !important;
            box-shadow: none;
        }

        .dz-form .form-control:focus.is-invalid,
        .dz-form .form-control:focus.parsley-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        .dz-form .form-control:focus.is-valid,
        .dz-form .form-control:focus.parsley-success {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
        }

        .parsley-errors-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        #contactSubmitButton:disabled {
            cursor: not-allowed;
            opacity: 0.75;
        }
    </style>
@endpush

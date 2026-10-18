@extends('layouts.app')

@section('title', 'Contact Us | FutureMap Media')

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')
    @include('frontend.partials.banner', ['header' => 'Contact Us'])

    {{-- Contact Information --}}
    <section class="content-inner">
        <div class="container">
            <div class="section-head style-1 text-center">
                <h6 class="sub-title text-primary">Contact Information</h6>
                <h2 class="title">We Would Love to Hear From You</h2>

                <p class="mx-auto" style="max-width: 750px;">
                    Contact FutureMap Media Concepts Limited for enquiries about
                    our media services, educational programmes, e-commerce
                    solutions, magazine publications and strategic partnerships.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="01">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary">
                                <i class="flaticon-telephone"></i>
                            </span>
                        </div>

                        <div class="icon-content">
                            <h4 class="title m-b10">Call Us</h4>
                            <p class="m-b0">
                                <a href="tel:+2348035082149">0803 508 2149</a>
                                <br>
                                <a href="tel:+2347062990717">0706 299 0717</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800"
                    data-aos-delay="400">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="02">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary">
                                <i class="flaticon-email"></i>
                            </span>
                        </div>

                        <div class="icon-content">
                            <h4 class="title m-b10">Email Us</h4>
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

                <div class="col-lg-4 col-md-12 m-b30 aos-item" data-aos="fade-up" data-aos-duration="800"
                    data-aos-delay="600">
                    <div class="icon-bx-wraper style-8 bg-white h-100" data-name="03">
                        <div class="icon-md m-r20">
                            <span class="icon-cell text-primary">
                                <i class="flaticon-placeholder"></i>
                            </span>
                        </div>

                        <div class="icon-content">
                            <h4 class="title m-b10">Visit Our Office</h4>
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
        <div class="map-iframe">
            <iframe
                src="https://www.google.com/maps?q=Real%20Tower%20Center%20No%2026%20A%20E%20Ekukinam%20Street%20Utako%20Abuja&amp;output=embed"
                class="align-self-stretch radius-sm" style="border: 0; width: 100%; min-height: 450px;" loading="lazy"
                allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                title="FutureMap Media Abuja Office Location"></iframe>
        </div>

        <div class="container">
            <div class="contact-area1 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">

                <div class="section-head style-1 text-center">
                    <h6 class="sub-title text-primary">Send Us a Message</h6>
                    <h2 class="title">Let’s Start a Conversation</h2>
                    <p>
                        Complete the form below and a member of our team will
                        respond to your enquiry.
                    </p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please correct the following:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="contactForm" class="style-1" method="POST" action="{{ route('contact.store') }}"
                    data-parsley-validate novalidate>
                    @csrf

                    <div class="row sp10">
                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    value="{{ old('first_name') }}" placeholder="First Name" autocomplete="given-name"
                                    maxlength="50" required data-parsley-required-message="Please enter your first name."
                                    data-parsley-minlength="2"
                                    data-parsley-minlength-message="Your first name must contain at least 2 characters."
                                    data-parsley-errors-container="#first_name_error">
                            </div>
                            <div id="first_name_error" class="field-error-container"></div>
                        </div>

                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    value="{{ old('last_name') }}" placeholder="Last Name" autocomplete="family-name"
                                    maxlength="50" required data-parsley-required-message="Please enter your last name."
                                    data-parsley-minlength="2"
                                    data-parsley-minlength-message="Your last name must contain at least 2 characters."
                                    data-parsley-errors-container="#last_name_error">
                            </div>
                            <div id="last_name_error" class="field-error-container"></div>
                        </div>

                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Email Address" autocomplete="email"
                                    maxlength="150" required
                                    data-parsley-required-message="Please enter your email address."
                                    data-parsley-type-message="Please enter a valid email address."
                                    data-parsley-errors-container="#email_error">
                            </div>
                            <div id="email_error" class="field-error-container"></div>
                        </div>

                        <div class="col-sm-6 m-b20">
                            <div class="input-group">
                                <input type="tel" name="phone" id="phone" class="form-control"
                                    value="{{ old('phone') }}" placeholder="Phone Number" autocomplete="tel"
                                    maxlength="30" data-parsley-pattern="^[0-9+\s()-]+$"
                                    data-parsley-pattern-message="Please enter a valid phone number."
                                    data-parsley-errors-container="#phone_error">
                            </div>
                            <div id="phone_error" class="field-error-container"></div>
                        </div>

                        <div class="col-sm-12 m-b20">
                            <div class="input-group">
                                <input type="text" name="subject" id="subject" class="form-control"
                                    value="{{ old('subject') }}" placeholder="Subject" maxlength="150" required
                                    data-parsley-required-message="Please enter the subject of your enquiry."
                                    data-parsley-minlength="3"
                                    data-parsley-minlength-message="The subject must contain at least 3 characters."
                                    data-parsley-errors-container="#subject_error">
                            </div>
                            <div id="subject_error" class="field-error-container"></div>
                        </div>

                        <div class="col-sm-12 m-b20">
                            <div class="input-group">
                                <textarea name="message" id="message" rows="6" class="form-control"
                                    placeholder="Write your message here..." maxlength="5000" required
                                    data-parsley-required-message="Please write your message." data-parsley-minlength="10"
                                    data-parsley-minlength-message="Your message must contain at least 10 characters."
                                    data-parsley-errors-container="#message_error">{{ old('message') }}</textarea>
                            </div>
                            <div id="message_error" class="field-error-container"></div>
                        </div>

                        {{-- Honeypot --}}
                        <div class="d-none" aria-hidden="true">
                            <label for="website">Leave this field empty</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        {{-- Cloudflare Turnstile --}}
                        <div class="col-sm-12 m-b20">
                            <div id="contactTurnstile"></div>

                            <div id="turnstile_error" class="field-error-container text-danger" role="alert"
                                aria-live="polite"></div>

                            <noscript>
                                <p class="text-danger">
                                    Please enable JavaScript to verify and send your message.
                                </p>
                            </noscript>
                        </div>

                        <div class="col-sm-12 text-center">
                            <button type="submit" id="contactSubmitButton" class="btn btn-primary btn-rounded">
                                <span class="submit-text">Send Message</span>
                                <span class="submit-loader d-none">Sending...</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Explicit rendering lets this form reset its own widget after AJAX requests.
        window.contactTurnstileWidgetId = null;

        window.onContactTurnstileLoad = function() {
            const container = document.getElementById('contactTurnstile');

            if (!container || window.contactTurnstileWidgetId !== null) {
                return;
            }

            window.contactTurnstileWidgetId = turnstile.render(container, {
                sitekey: @json(config('services.turnstile.site_key')),
                action: 'contact',
                theme: 'auto',
                size: 'flexible',

                callback: function() {
                    document.getElementById('turnstile_error').textContent = '';
                },

                'expired-callback': function() {
                    document.getElementById('turnstile_error').textContent =
                        'Verification expired. Please complete verification again.';
                },

                'error-callback': function() {
                    document.getElementById('turnstile_error').textContent =
                        'Security verification could not load. Please refresh the page.';
                }
            });
        };

        $(function() {
            const $form = $('#contactForm');
            const $submitButton = $('#contactSubmitButton');
            const $turnstileError = $('#turnstile_error');
            let submitting = false;

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
                extendedTimeOut: 2000,
                escapeHtml: true
            };

            function resetTurnstile() {
                if (
                    window.turnstile &&
                    window.contactTurnstileWidgetId !== null
                ) {
                    turnstile.reset(window.contactTurnstileWidgetId);
                }
            }

            function clearServerErrors() {
                $form.find('.server-validation-error').remove();
                $form.find('.form-control')
                    .removeClass('is-invalid server-invalid');
                $turnstileError.empty();
            }

            function setSubmitting(value) {
                submitting = value;
                $submitButton.prop('disabled', value);
                $submitButton.find('.submit-text, .submit-icon')
                    .toggleClass('d-none', value);
                $submitButton.find('.submit-loader, .spinner-border')
                    .toggleClass('d-none', !value);
            }

            function displayServerErrors(errors) {
                Object.entries(errors).forEach(function([field, messages]) {
                    const message = Array.isArray(messages) ?
                        messages[0] :
                        messages;

                    if (field === 'cf-turnstile-response') {
                        $turnstileError.text(message);
                        return;
                    }

                    const $field = $form.find('[name]').filter(function() {
                        return this.name === field;
                    });

                    if (!$field.length) {
                        return;
                    }

                    $field.addClass('is-invalid server-invalid');

                    const container = document.getElementById(field + '_error');
                    const $error = $('<div>', {
                        class: 'invalid-feedback d-block server-validation-error',
                        text: message
                    });

                    if (container) {
                        $(container).append($error);
                    } else {
                        $field.after($error);
                    }
                });

                const $firstInvalid = $form
                    .find('.form-control.server-invalid')
                    .first();

                if ($firstInvalid.length) {
                    $firstInvalid[0].focus();
                }
            }

            $form.on('input change', '.form-control', function() {
                const container = document.getElementById(this.name + '_error');

                $(this).removeClass('server-invalid');

                if (container) {
                    $(container).find('.server-validation-error').remove();
                }

                if (!$(this).hasClass('parsley-error')) {
                    $(this).removeClass('is-invalid');
                }
            });

            $form.on('submit', function(event) {
                event.preventDefault();

                if (submitting) {
                    return;
                }

                clearServerErrors();

                if (!parsleyForm.validate()) {
                    toastr.warning(
                        'Please correct the highlighted fields before sending your message.',
                        'Check the Form'
                    );
                    return;
                }

                if (
                    !window.turnstile ||
                    window.contactTurnstileWidgetId === null ||
                    !turnstile.getResponse(window.contactTurnstileWidgetId)
                ) {
                    $turnstileError.text(
                        'Please complete the security verification before sending.'
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
                        if (response.success === false) {
                            toastr.error(
                                response.message || 'We could not send your message.',
                                'Submission Failed'
                            );
                            return;
                        }

                        toastr.success(
                            response.message || 'Your message has been sent successfully.',
                            'Message Sent'
                        );

                        $form[0].reset();
                        parsleyForm.reset();
                        clearServerErrors();

                        $form.find('.form-control').removeClass(
                            'is-valid is-invalid parsley-success parsley-error server-invalid'
                        );
                    },

                    error: function(xhr) {
                        const response = xhr.responseJSON || {};

                        if (xhr.status === 422) {
                            displayServerErrors(response.errors || {});

                            toastr.error(
                                'Please correct the highlighted fields.',
                                'Validation Failed'
                            );
                            return;
                        }

                        if (xhr.status === 429) {
                            toastr.warning(
                                'You have submitted too many messages. Please wait before trying again.',
                                'Too Many Requests'
                            );
                            return;
                        }

                        if (xhr.status === 419) {
                            toastr.error(
                                'Your session has expired. Please refresh the page before trying again.',
                                'Session Expired'
                            );
                            return;
                        }

                        toastr.error(
                            response.message ||
                            'We could not send your message. Please try again.',
                            'Submission Failed'
                        );
                    },

                    complete: function() {
                        // A submitted token may already have been consumed.
                        resetTurnstile();
                        setSubmitting(false);
                    }
                });
            });
        });
    </script>

    {{-- Load Turnstile only once on this page. --}}
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onContactTurnstileLoad&render=explicit" async
        defer></script>
@endpush

@push('styles')
    <style>
        .field-error-container {
            width: 100%;
            margin-top: 5px;
        }

        .field-error-container .invalid-feedback,
        #turnstile_error {
            font-size: 13px;
            line-height: 1.4;
        }

        .field-error-container .invalid-feedback {
            display: block;
            margin: 0;
        }

        #contactForm .form-control.is-invalid,
        #contactForm .form-control.parsley-error {
            border-color: #dc3545 !important;
            box-shadow: none;
        }

        #contactForm .form-control.is-valid,
        #contactForm .form-control.parsley-success {
            border-color: #198754 !important;
            box-shadow: none;
        }

        #contactForm .form-control:focus.is-invalid,
        #contactForm .form-control:focus.parsley-error {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }

        #contactForm .form-control:focus.is-valid,
        #contactForm .form-control:focus.parsley-success {
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

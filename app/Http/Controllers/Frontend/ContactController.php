<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'phone' => [
                'nullable',
                'string',
                'max:30',
                'regex:/^[0-9+\-\s()]+$/',
            ],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],

            // Must remain empty.
            'website' => ['nullable', 'string', 'max:0'],

            'cf-turnstile-response' => [
                'required',
                'string',
                'max:2048',
            ],
        ], [
            'website.max' => 'Your submission could not be accepted.',
            'cf-turnstile-response.required' => 'Please complete the security verification.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        /*
        |--------------------------------------------------------------------------
        | Validate Turnstile Configuration
        |--------------------------------------------------------------------------
        */

        $secretKey = config('services.turnstile.secret_key');
        $expectedHostname = config('services.turnstile.hostname');

        if (
            ! is_string($secretKey) || trim($secretKey) === '' ||
            ! is_string($expectedHostname) || trim($expectedHostname) === ''
        ) {
            Log::error('Contact form Turnstile configuration is incomplete.');

            return response()->json([
                'success' => false,
                'message' => 'The contact form is temporarily unavailable. Please try again later.',
            ], 503);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Turnstile Before Sending Email
        |--------------------------------------------------------------------------
        */

        try {
            $response = Http::asForm()
                ->connectTimeout(5)
                ->timeout(10)
                ->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    [
                        'secret' => $secretKey,
                        'response' => $validated['cf-turnstile-response'],
                    ]
                );
        } catch (ConnectionException $exception) {
            Log::warning('Contact form Turnstile connection failed.');

            return response()->json([
                'success' => false,
                'message' => 'Security verification is temporarily unavailable. Please try again shortly.',
            ], 503);
        }

        if (! $response->successful()) {
            Log::warning('Contact form Turnstile service returned an error.', [
                'status' => $response->status(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Security verification is temporarily unavailable. Please try again shortly.',
            ], 503);
        }

        $verification = $response->json();

        if (
            ! is_array($verification) ||
            ($verification['success'] ?? false) !== true ||
            ($verification['action'] ?? '') !== 'contact' ||
            ($verification['hostname'] ?? '') !== $expectedHostname
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete the security verification again.',
                'errors' => [
                    'cf-turnstile-response' => [
                        'Security verification failed or expired. Please try again.',
                    ],
                ],
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Contact Email Data
        |--------------------------------------------------------------------------
        |
        | Pass only the contact fields to the mailable.
        |
        */

        $contact = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Send Contact Email
        |--------------------------------------------------------------------------
        */

        try {
            Mail::to('info@fmapmedia.com')
                ->send(new ContactMessageMail($contact));

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting FMAP Media. Your message has been sent successfully.',
            ]);
        } catch (Throwable $exception) {
            Log::error('Contact form email failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'We could not send your message at this time. Please try again shortly.',
            ], 500);
        }
    }
}

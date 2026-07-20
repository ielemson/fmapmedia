<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Throwable;

class ContactController extends Controller
{

/**
     * Generate a new session CAPTCHA.
     */
    public function captcha(Request $request): JsonResponse
    {
        $firstNumber = random_int(1, 9);
        $secondNumber = random_int(1, 9);

        $request->session()->put(
            'contact_captcha_answer',
            $firstNumber + $secondNumber
        );

        $request->session()->put(
            'contact_captcha_generated_at',
            now()->timestamp
        );

        return response()->json([
            'success'  => true,
            'question' => "{$firstNumber} + {$secondNumber}",
        ]);
    }

    public function store(Request $request): JsonResponse
{
    $validator = Validator::make(
        $request->all(),
        [
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name'  => ['required', 'string', 'min:2', 'max:50'],
            'email'      => ['required', 'email', 'max:150'],
            'phone'      => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'subject'    => ['required', 'string', 'min:3', 'max:150'],
            'message'    => ['required', 'string', 'min:10', 'max:5000'],

            // Honeypot
            'website' => ['nullable', 'max:0'],

            // CAPTCHA
            'captcha_answer' => ['required', 'integer'],
        ]
    );

    /*
    |--------------------------------------------------------------------------
    | Custom CAPTCHA Validation
    |--------------------------------------------------------------------------
    */
    $validator->after(function ($validator) use ($request) {

        $expected = $request->session()->get('contact_captcha_answer');

        if ($expected === null) {

            $validator->errors()->add(
                'captcha_answer',
                'Security question expired. Please refresh the page.'
            );

            return;
        }

        if ((int)$request->captcha_answer !== (int)$expected) {

            // Generate a fresh CAPTCHA immediately
            $a = random_int(1, 9);
            $b = random_int(1, 9);

            $request->session()->put([
                'contact_captcha_answer' => $a + $b,
                'contact_captcha_question' => "{$a} + {$b}",
            ]);

            $validator->errors()->add(
                'captcha_answer',
                'Incorrect security answer.'
            );
        }
    });

    if ($validator->fails()) {

        return response()->json([
            'success' => false,
            'message' => 'Please correct the highlighted fields.',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $contact = $validator->validated();

    unset(
        $contact['website'],
        $contact['captcha_answer']
    );

    try {

        Mail::to('info@fmapmedia.com')
            ->send(new ContactMessageMail($contact));

        // Destroy the used CAPTCHA
        $request->session()->forget([
            'contact_captcha_answer',
            'contact_captcha_question',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting FMAP Media. Your message has been sent successfully.',
        ]);

    } catch (Throwable $exception) {

        Log::error('Contact form email failed.', [
            'email' => $contact['email'] ?? null,
            'subject' => $contact['subject'] ?? null,
            'exception' => $exception->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'We could not send your message at this time. Please try again shortly.',
        ], 500);
    }
}









    //  public function store(StoreContactRequest $request): JsonResponse
    // {
    //     $contact = $request->safe()->except('website');

    //     try {
    //         Mail::to('info@fmapmedia.com')
    //             ->send(new ContactMessageMail($contact));

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Thank you for contacting FMAP Media. Your message has been sent successfully.',
    //         ]);
    //     } catch (Throwable $exception) {
    //         Log::error('Contact form email failed.', [
    //             'email' => $contact['email'] ?? null,
    //             'subject' => $contact['subject'] ?? null,
    //             'exception' => $exception->getMessage(),
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'We could not send your message at this time. Please try again shortly.',
    //         ], 500);
    //     }
    // }


    // public function captcha(): JsonResponse
    // {
    //     $firstNumber = random_int(1, 10);
    //     $secondNumber = random_int(1, 10);

    //     session([
    //         'contact_captcha_answer' => $firstNumber + $secondNumber,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'question' => "{$firstNumber} + {$secondNumber}",
    //     ]);
    // }

}

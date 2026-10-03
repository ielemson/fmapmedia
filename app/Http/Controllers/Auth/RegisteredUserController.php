<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
            'cf-turnstile-response' => [
                'required',
                'string',
                'max:2048',
            ],
        ], [
            'cf-turnstile-response.required' => 'Please complete the security verification.',
        ]);

        // Verify Turnstile before creating an account.
        $secretKey = config('services.turnstile.secret_key');
        $expectedHostname = config('services.turnstile.hostname');

        // Reject registration if server configuration is incomplete.
        if (
            ! is_string($secretKey) || trim($secretKey) === '' ||
            ! is_string($expectedHostname) || trim($expectedHostname) === ''
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Registration is temporarily unavailable. Please try again later.',
            ]);
        }

        $verification = [];

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

            if ($response->successful()) {
                $result = $response->json();

                if (is_array($result)) {
                    $verification = $result;
                }
            }
        } catch (ConnectionException $exception) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Security verification is temporarily unavailable. Please refresh the page and try again.',
            ]);
        }

        if (
            ($verification['success'] ?? false) !== true ||
            ($verification['action'] ?? '') !== 'register' ||
            ($verification['hostname'] ?? '') !== $expectedHostname
        ) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Security verification failed. Please refresh the page and try again.',
            ]);
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('Customer');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

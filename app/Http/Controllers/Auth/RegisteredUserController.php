<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        //     'first_name' => ['required', 'string', 'max:255'],
        //     'last_name' => ['required', 'string', 'max:255'],
        //     'role' => ['required', 'string', Rule::in(['customer', 'vendor', 'admin'])],
        //     'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/', 'max:20'],
        //     'avatar' => ['required', 'string', 'max:255'],
        //     'status' => ['required', 'string', Rule::in(['active', 'inactive', 'suspended'])],
        //     'date_of_birth' => ['required', 'date', 'before:today'],
        //     'place_of_residence' => ['required', 'string', 'max:255'],
        //     'gender' => ['required', 'string', Rule::in(['male', 'female'])],
        //     'remember_token' => ['required', 'string', 'max:255'],
        // ]);
$request->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'phone' => ['required', 'numeric'],
    'date_of_birth' => ['required', 'date'],
    'gender' => ['required', 'string'],
]);




        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

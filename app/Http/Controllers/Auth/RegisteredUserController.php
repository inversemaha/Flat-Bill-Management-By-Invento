<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,house_owner'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->role === 'house_owner' ? 'pending' : 'active', // House owners need approval
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        // Don't auto-login house owners if they're pending approval
        if ($user->isActive()) {
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect()->route('login')
                ->with('status', 'Registration successful! Your account is pending admin approval. You will be notified once approved.');
        }
    }
}

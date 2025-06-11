<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->route('token');
        $invitation = null;

        if ($token) {
            $invitation = Invitation::where('token', $token)
                ->where('expires_at', '>', now())
                ->firstOrFail();
        }

        return view('auth.register', compact('invitation'));
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $userData = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'member', // Default role
    ];

    if ($request->has('invitation_token')) {
        $invitation = Invitation::where('token', $request->invitation_token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $userData['role'] = $invitation->role;
        $userData['company_id'] = $invitation->company_id;

        $invitation->delete();
    } else {
        // Assign to a default company if no invitation
        $defaultCompany = Company::firstOrCreate(['name' => 'Default Company']);
        $userData['company_id'] = $defaultCompany->id;
    }

    $user = User::create($userData);

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}
}
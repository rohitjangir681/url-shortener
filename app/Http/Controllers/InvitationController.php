<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\InvitationEmail;


class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('invited_by', auth()->id())->get();
        return view('invitations.index', compact('invitations'));
    }

    public function create()
    {
        $companies = auth()->user()->isSuperAdmin() 
            ? Company::all() 
            : Company::where('id', auth()->user()->company_id)->get();
            
        return view('invitations.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,member',
            'company_id' => auth()->user()->isSuperAdmin() 
                ? 'required|exists:companies,id' 
                : 'nullable'
        ]);

        $companyId = auth()->user()->isSuperAdmin() 
            ? $request->company_id 
            : auth()->user()->company_id;

        $token = Str::random(32);

        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'role' => $request->role,
            'company_id' => $companyId,
            'invited_by' => auth()->id(),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($request->email)->send(new InvitationEmail($invitation));

        return redirect()->route('invitations.index')->with('success', 'Invitation sent successfully.');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('auth.register', compact('invitation'));
    }
}
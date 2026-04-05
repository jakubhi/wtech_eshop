<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('pages.register_page');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'meno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'heslo' => ['required', 'string', 'min:8'],
        ], [
            'meno.required' => 'Meno je povinné.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadajte platný email.',
            'email.unique' => 'Tento email je už registrovaný.',
            'heslo.required' => 'Heslo je povinné.',
            'heslo.min' => 'Heslo musí mať aspoň :min znakov.',
        ]);

        User::create([
            'name' => $validated['meno'],
            'email' => $validated['email'],
            'password' => $validated['heslo'],
        ]);

        return redirect()->route('login')->with('status', 'Registrácia prebehla úspešne. Môžete sa prihlásiť.');
    }
}

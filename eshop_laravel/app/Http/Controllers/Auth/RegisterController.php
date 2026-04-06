<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('pages.register_page');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'heslo' => ['required', 'string', 'min:8'],
        ], [
            'login.required' => 'Login je povinný.',
            'login.unique' => 'Tento login sa už používa.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadajte platný email.',
            'email.unique' => 'Tento email je už registrovaný.',
            'heslo.required' => 'Heslo je povinné.',
            'heslo.min' => 'Heslo musí mať aspoň :min znakov.',
        ]);

        User::create([
            'login' => $validated['login'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['heslo']),
            'rola' => ($request->query('type') === 'admin') ? 'admin' : 'zakaznik',
        ]);

        return redirect()->route('login')->with('status', 'Registrácia prebehla úspešne. Môžete sa prihlásiť.');
    }
}

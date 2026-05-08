<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CartSyncService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(private readonly CartSyncService $cartSyncService) {
        
    }

    public function create(): View
    {
        return view('pages.register_page');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $user = $this->createUser($validated, (string) $request->query('type'));

        Auth::login($user);
        $request->session()->regenerate();

        $this->cartSyncService->mergeCurrentSessionCart((int) $user->pouzivatel_id);

        return $user->rola === 'admin'
            ? redirect()->intended('admin_dashboard')
            : redirect()->intended('/');
    }

    private function rules(): array
    {
        return [
            'login' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'heslo' => ['required', 'string', 'min:8'],
        ];
    }

    private function messages(): array
    {
        return [
            'login.required' => 'Login je povinný.',
            'login.unique' => 'Tento login sa už používa.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Zadajte platný email.',
            'email.unique' => 'Tento email je už registrovaný.',
            'heslo.required' => 'Heslo je povinné.',
            'heslo.min' => 'Heslo musí mať aspoň :min znakov.',
        ];
    }

    private function createUser(array $validated, string $type): User
    {
        $role = $type === 'admin' ? 'admin' : 'zakaznik';

        return User::create([
            'login' => $validated['login'],
            'email' => $validated['email'],
            'heslo' => Hash::make($validated['heslo']),
            'rola' => $role,
        ]);
    }
}

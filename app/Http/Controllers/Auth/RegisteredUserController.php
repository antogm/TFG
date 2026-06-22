<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entrenador;
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
        // Valida los datos de registro
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'in:usuario,entrenador'], 
            'genero' => ['required', 'in:Masculino,Femenino,Prefiero no especificarlo'],
            'altura' => ['required', 'integer', 'min:0', 'max:500'],
            'objetivo' => ['required', 'in:Pérdida de grasa,Aumento de masa muscular,Recomposición corporal,Sin objetivo marcado'],
        ]);

        // Crea al nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'genero' => $request->genero,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
        ]);

        // Si el registro ha sido como entrenador, lo añade a su tabla 
        if ($user->rol === 'entrenador'){
            $entrenador = new Entrenador();
            $entrenador->id = $user->id;
            $entrenador->save();
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

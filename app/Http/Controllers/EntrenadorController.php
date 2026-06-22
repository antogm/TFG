<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTrainerProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EntrenadorController extends Controller
{
    public function index(){

    }

    public function clientes(Request $request){
        $search = trim((string) $request->query('search', ''));
        $clientes = Auth::user()->entrenador->getClientes($search);

        return view('entrenador.lista-clientes', compact('clientes'));
    }

    public function updateProfile(UpdateTrainerProfileRequest $request){
        $user = Auth::user();
        $entrenador = $user->entrenador;
        $entrenador->update($request->validated());

        return Redirect::route('profile.edit')->with('status', 'trainer-profile-updated');
    }

    public function altaEntrenador(): RedirectResponse
    {
        Auth::user()->altaEntrenador();

        return Redirect::route('profile.edit')->with('status', 'trainer-profile-activated');
    }

    public function bajaEntrenador(): RedirectResponse
    {
        Auth::user()->bajaEntrenador();

        return Redirect::route('profile.edit')->with('status', 'trainer-profile-deactivated');
    }

    public function dashboard(){
        $dashboardData = Auth::user()->entrenador->datosDashboard();

        return view('entrenador.dashboard', $dashboardData);
    }
}

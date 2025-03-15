<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PerfilUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('authenticated') || !Session::get('authenticated')) {
                return redirect()->route('login')->withErrors(['auth' => 'Debe iniciar sesión para acceder a esta página.']);
            }

            $userEmail = Session::get('user_email');
            $usuario = DB::table('tb_usuarios')->where('email', $userEmail)->first();

            if (!$usuario) {
                Session::flash('access_restricted', true);
                return redirect()->route('login')->withErrors(['auth' => 'No tienes permiso para acceder a esta página.']);
            }

            return $next($request);
        });
    }

    public function index()
    {
        return view('perfil_usuario');
    }

    // Otros métodos del controlador
}

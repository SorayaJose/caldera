<?php

namespace App\Http\Controllers;

use App\Models\Dolar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        $puedeGestionar = $user && ($user->tienePermiso('medio') || (int) ($user->rol ?? 0) === User::ROL_ADMIN);

        // Usuarios limitados siguen entrando directo a vencimientos
        if ($user && !$puedeGestionar) {
            return redirect()->route('vencimientos.index');
        }

        $dolar = Dolar::whereDate('fecha', '<=', Carbon::today())
        ->orderBy('fecha', 'desc')
        ->orderBy('id', 'desc')
        ->first();
        return view('home.index', [
            'dolar' => $dolar,
            'user' => $user,
        ]);
    }

    public function cambioModo()
    {
        //$user = Auth::user();

        // asignar nuevos valores
        /*

        */

        //Auth::user()->muestro();
        //cache(['modoSivezul' => 'S'], 30000000);
        //dd($valor);
        //cache(['key' => 'value'], 300);

        $modo = cache('modoSivezul');
        if ($modo == 'S') {
            $modo = 'P';
        } else {
            $modo = 'S';
        }
        cache(['modoSivezul' => $modo], 30000000);
        //dd(cache('modoSivezul'));
        //dd(Auth::user()->rol);
        // guardar el registrossssss
        //$user->save();
        
        return redirect()->to('/');
    }
    
}

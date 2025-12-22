<?php

namespace App\Http\Controllers;

use App\Models\Dolar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

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
        //dd('dentro del invoke');
        //$modo = Config::get('app.modo');
        //if (Auth::check()) {
            $dolar = Dolar::whereDate('fecha', '<=', Carbon::today())
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->first();
            return view('home.index', [
                'dolar' => $dolar
            ]);           
        //} else {
        //    dd('sin login');
        //}

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
        
        return redirect::to('/');
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{

    public function actualizarValor(Request $request, $id)
    {
        $nuevoValor = $request->input('valor');
        //$dato = TuModelo::findOrFail($id);
        //$dato->valor = $nuevoValor;
        //$dato->save();
        $tmp = 'id' . $id . " valor:" . $request->input('valor');
        dd($tmp);
        return redirect()->back()->with('success', 'Valor actualizado correctamente.'.$tmp);
    }

    public function index()
    {
        //$this->authorize('viewAny', Cuenta::class);
        return view('cuentas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', Cuenta::class);
        return view('cuentas.create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cuenta $cuenta)
    {
        return view('cuentas.show', [
            'cuentas' => $cuenta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuenta $cuenta)
    {
        //dd($cuenta);
        //$this->authorize('update', $cuenta);

        return view('cuentas.edit', [
            'cuenta' => $cuenta
        ]);
    }
}

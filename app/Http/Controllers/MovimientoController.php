<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index()
    {
        //$this->authorize('viewAny', Movimiento::class);
        return view('movimientos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', Movimiento::class);
        return view('movimientos.create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento $movimiento)
    {
        return view('movimientos.show', [
            'movimientos' => $movimiento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimiento $movimiento)
    {
        //dd($movimiento);
        //$this->authorize('update', $movimiento);

        return view('movimientos.edit', [
            'movimiento' => $movimiento
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Vencimiento;
use Illuminate\Http\Request;

class VencimientoController extends Controller
{
    public function index()
    {
        //$this->authorize('viewAny', Vencimiento::class);
        return view('vencimientos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', Vencimiento::class);
        return view('vencimientos.create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vencimiento $vencimiento)
    {
        return view('vencimientos.show', [
            'vencimientos' => $vencimiento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vencimiento $vencimiento)
    {
        //dd($vencimiento);
        //$this->authorize('update', $vencimiento);

        return view('vencimientos.edit', [
            'vencimiento' => $vencimiento
        ]);
    }
}

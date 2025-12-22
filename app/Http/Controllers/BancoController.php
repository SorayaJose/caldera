<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function index()
    {
        //$this->authorize('viewAny', Banco::class);
        return view('bancos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', Banco::class);
        return view('bancos.create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banco $banco)
    {
        return view('bancos.show', [
            'bancos' => $banco
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banco $banco)
    {
        //dd($Banco);
        //$this->authorize('update', $Banco);

        return view('bancos.edit', [
            'banco' => $banco
        ]);
    }
}

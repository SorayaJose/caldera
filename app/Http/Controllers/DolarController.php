<?php

namespace App\Http\Controllers;

use App\Models\Dolar;
use Illuminate\Http\Request;

class DolarController extends Controller
{
    public function index()
    {
        //$this->authorize('viewAny', Apartamento::class);
        return view('dolares.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', Dolar::class);
        return view('dolares.create');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dolar $dolar)
    {
        return view('dolares.show', [
            'dolar' => $dolar
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dolar $dolar)
    {
        //dd($dolar);
        //$this->authorize('update', $dolar);

        return view('dolares.edit', [
            'dolar' => $dolar
        ]);
    }
}

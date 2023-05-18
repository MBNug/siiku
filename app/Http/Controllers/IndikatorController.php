<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Http\Requests\StoreIndikatorRequest;
use App\Http\Requests\UpdateIndikatorRequest;

class IndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIndikatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIndikatorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indikator  $indikator
     * @return \Illuminate\Http\Response
     */
    public function show(Indikator $indikator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indikator  $indikator
     * @return \Illuminate\Http\Response
     */
    public function edit(Indikator $indikator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIndikatorRequest  $request
     * @param  \App\Models\Indikator  $indikator
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIndikatorRequest $request, Indikator $indikator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indikator  $indikator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indikator $indikator)
    {
        //
    }
}

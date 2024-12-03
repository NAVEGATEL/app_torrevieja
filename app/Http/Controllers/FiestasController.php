<?php

namespace App\Http\Controllers;

use App\Models\Fiesta;
use Illuminate\Http\Request;

class FiestasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.fiestas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fiesta $fiesta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fiesta $fiesta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fiesta $fiesta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fiesta $fiesta)
    {
        //
    }
}

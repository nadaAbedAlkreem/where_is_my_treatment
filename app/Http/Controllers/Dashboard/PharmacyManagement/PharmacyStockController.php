<?php

namespace App\Http\Controllers\Dashboard\PharmacyManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePharmacyStockRequest;
use App\Http\Requests\UpdatePharmacyStockRequest;
use App\Models\PharmacyStock;

class PharmacyStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePharmacyStockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PharmacyStock $pharmacyStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PharmacyStock $pharmacyStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyStockRequest $request, PharmacyStock $pharmacyStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PharmacyStock $pharmacyStock)
    {
        //
    }
}

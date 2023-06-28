<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use App\Http\Requests\StoreCustomerTypeRequest;
use App\Http\Requests\UpdateCustomerTypeRequest;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $types = CustomerType::get();
        return $types;
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
    public function store(StoreCustomerTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerType $customerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerType $customerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerTypeRequest $request, CustomerType $customerType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerType $customerType)
    {
        //
    }
}

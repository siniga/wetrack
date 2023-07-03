<?php

namespace App\Http\Controllers;

use App\Models\purchase_rejection_reasons;
use App\Http\Requests\Storepurchase_rejection_reasonsRequest;
use App\Http\Requests\Updatepurchase_rejection_reasonsRequest;

class PurchaseRejectionReasonsController extends Controller
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
     * @param  \App\Http\Requests\Storepurchase_rejection_reasonsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storepurchase_rejection_reasonsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\purchase_rejection_reasons  $purchase_rejection_reasons
     * @return \Illuminate\Http\Response
     */
    public function show(purchase_rejection_reasons $purchase_rejection_reasons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\purchase_rejection_reasons  $purchase_rejection_reasons
     * @return \Illuminate\Http\Response
     */
    public function edit(purchase_rejection_reasons $purchase_rejection_reasons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatepurchase_rejection_reasonsRequest  $request
     * @param  \App\Models\purchase_rejection_reasons  $purchase_rejection_reasons
     * @return \Illuminate\Http\Response
     */
    public function update(Updatepurchase_rejection_reasonsRequest $request, purchase_rejection_reasons $purchase_rejection_reasons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\purchase_rejection_reasons  $purchase_rejection_reasons
     * @return \Illuminate\Http\Response
     */
    public function destroy(purchase_rejection_reasons $purchase_rejection_reasons)
    {
        //
    }
}

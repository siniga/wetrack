<?php

namespace App\Http\Controllers;

use App\Models\CustomerVisit;
use App\Http\Requests\StoreCustomerVisitRequest;
use App\Http\Requests\UpdateCustomerVisitRequest;
use Illuminate\Http\Request;

class CustomerVisitController extends Controller
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
    public function store(Request $request)
    {
        //
        $visit  = new CustomerVisit;
        $visit->time_spent = $request->time_spent;
        $visit->business_id = $request->business_id;
        $visit->customer_id = $request->customer_id;
        $visit->user_id = $request->user_id;

        if($visit->save()){
            return response()->json($visit);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerVisitRequest $request, CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerVisit $customerVisit)
    {
        //
    }

    public function getVisitsByBusinessId($businessId){
        $customerVisit = CustomerVisit::where('business_id', $businessId)
        ->get();

        return response()->json($customerVisit);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\CustomerVisit;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        //
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        //
        $customer  = new Customer;
        $customer->name = $request->name;
        $customer->customer_type_id = $request->customer_type_id;
        $customer->phone = $request->phone;
        $customer->location = $request->location;
        $customer->lat = $request->lat;
        $customer->lng = $request->lng;
        $customer->district_id = $request->district_id;
        $customer->business_id = $request->business_id;
        $customer->created_date = $request->created_date;
        $customer->device_time = $request->device_time;
        $customer->user_id = $request->user_id;

        if($customer->save()){
            $customer->load('customerType');

            return response()->json($customer);
        }
    }


    public function update( Request $request ) {
        //
        $customer  = Customer::findOrFail($request->id);
        $customer->name = $request->name;
        $customer->customer_type_id = $request->customer_type_id;
        $customer->phone = $request->phone;
        $customer->location = $request->location;
        $customer->lat = $request->lat;
        $customer->lng = $request->lng;
        $customer->district_id = $request->district_id;
        $customer->business_id = $request->business_id;
        $customer->created_date = $request->created_date;
        $customer->device_time = $request->device_time;
        $customer->user_id = $request->user_id;

        if($customer->save()){
            $customer->load('customerType');

            return response()->json($customer);
        }
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Customer $customer ) {
        //
    }

    public function getCustomersByBusinessId( $businessId ) {
        $customers = Customer::with( 'user', 'district', 'customerType' )
        ->where( 'business_id', $businessId )
        ->orderBy( 'id', 'desc' )
        ->get();

        return response()->json( $customers );
    }

    public function getCustomerByUserid(){
        $user = Auth::user();

        $customers = Customer::with( 'user', 'district', 'customerType' )
        ->where( 'user_id', $user->id )
        ->orderBy( 'id', 'desc' )
        ->get();

        return response()->json( $customers );
    }
    public function insertCustomers() {
        // Assuming you have already imported the necessary classes at the top of your file
        // Generate an array of 200 rows with randomized 'time_spent' values
        $rows = [];
        for ( $i = 1; $i <= 200; $i++ ) {
            $timeSpent = rand( 1, 60 ) . ' minutes';
            // Randomize the minutes between 1 and 60
            $rows[] = array(
                'time_spent' => $timeSpent,
                'customer_id' => '23',
                'user_id' => '4',
                'business_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            );
        }

        // Use the 'insert' method provided by Eloquent to insert the rows
        CustomerVisit::insert( $rows );

        //     foreach ( $items as $item ) {
        //         $customer = new Order;
        //         $customer->status = $item[ 'status' ];
        //         $customer->order_no = $item[ 'order_no' ];
        //         $customer->device_time = $item[ 'device_time' ];
        //         $customer->lat = $item[ 'lat' ];
        //         $customer->lng = $item[ 'lng' ];
        //         $customer->user_id = 4;
        //         $customer->customer_id = mt_rand( 12, 248 );
        //         $customer->business_id = 1;

        //         $customer->save();
        //     }

        // }
    }
}

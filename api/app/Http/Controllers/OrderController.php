<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends Controller {
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

    public function getByStatusBusinessId( $status, $bid ) {
        $orders = Order::with( 'customers','user' )
        ->where( 'business_id', $bid )
        ->where( 'status', $status )
        ->get();

       return response( [ 'order'=> $orders ], 201 );
    }

    public function getOrderByBusinessId( $bid ) {
        
        $orders = Order::with( 'customers','user' )
        ->where( 'business_id', $bid )
        ->get();

       return response( [ 'order'=> $orders ], 201 );
    }

    public function getOrdersByUserid($date, $status){
        $user = Auth::user();

        $orders = Order::with('products')->has('products')
        ->where( 'user_id', $user->id)
        ->where('status', $status)
        ->whereDate('device_time', $date)
        ->orderBy( 'id', 'desc' )
        ->get();
        
       return response()->json( $orders );
    }

    public function getOrderMarkersByBusinessId($businessId, $flag, $userId){
        //flag to query sales data for one user, region or country
      

        if($flag == 1){
            //country
            $orders = Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->join('customer_types','customer_types.id', 'customers.customer_type_id')
            ->select('orders.id', 'orders.lat', 'orders.lng', 'customer_types.name as customer_type')
            ->where('orders.business_id', $businessId)
            ->get();
        }else{
            //single sales agent
            $orders = Order::leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->join('customer_types','customer_types.id', 'customers.customer_type_id')
            ->select('orders.id', 'orders.lat', 'orders.lng', 'customer_types.name as customer_type')
            ->where('orders.business_id', $businessId)
            ->where('orders.user_id', $userId)
            ->get();
        }
       


        $orderModified =$orders->map(function ($order) {
            return [
                'id' => $order->id,
                'lngLat' => [(float)$order->lng, (float)$order->lat],
                 'title'=> $order->customer_type
            ];
        });

        //add customer lat and longitudes to the orders
       return response( [ 'order'=> $orderModified ], 200);
        // {
        //     id: 7,
        //     lngLat: [39.2875, -6.793],
        //     title: "H",
        //   },
    }

    public function store( Request $request ) {
        if ( !Order::where( 'order_no', '=', $request->order_no )->exists() ) {

            //TODO: validate all the fields before insertion
            $order  = new Order;
            $order->device_time = $request->device_time;
            $order->order_no = $request->order_no;
            $order->status  = $request->status;
            $order->location = $request->location;
            $order->lng = $request->lng;
            $order->lat = $request->lat;
            $order->user_id  = $request->user_id;
            $order->customer_id = $request->customer_id;
            $order->business_id = $request->business_id;

            if ( $order->save() ) {

                $carts = $request->carts;

                foreach ( $carts as $cart ) {
                    $this->attachToProduct( $order->id, $cart );
                }

                return response( [ 'order'=> $order ], 201 );
            }

        } else {

            $order = Order::where( 'order_no', $request->order_no )->first();
            return response( [ 'order'=> [ 'order_no'=> $order ], 'error_msg'=>'Order no already exists' ], 201 );

        }
    }

    /**
    * Display the specified resource.
    */

    public function show( Order $order ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Order $order ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( UpdateOrderRequest $request, Order $order ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Order $order ) {
        //
    }

    public function attachToProduct( $oid, $cart ) {

        $order = Order::findOrFail( $oid );

        // return $cart[ 'total_quantity' ];
        //TODO:dont forget to change the values on android
        $orderProduct =  new OrderProduct;
        $orderProduct->total_quantity = $cart[ 'total_quantity' ];
        $orderProduct->total_amount  =  $cart[ 'total_amount' ];
        $orderProduct->product_id =  $cart[ 'product_id' ];
        $orderProduct->order_id = $oid;

        $orderProduct->save();

        // if ( !$cartExist ) {
        // $order->products()->syncWithoutDetaching( [
        //     $cart[ 'product_id' ] => [
        //         'total_quantity' => $cart[ 'total_quantity' ],
        //         'total_amount' => $cart[ 'total_amount' ]
        // ]
        // ] );
        // }

    }

    public function exportData() 
   
    { 
   
        return Excel::download(new OrderExport, 'Sales.xlsx');
    }
   
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

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
        $orders = Order::with( 'customer','user' )
        ->where( 'business_id', $bid )
        ->where( 'status', $status )
        ->get();

       return response( [ 'order'=> $orders ], 201 );
    }

    public function getOrderByBusinessId( $bid ) {
        $orders = Order::with( 'customer','user' )
        ->where( 'business_id', $bid )
        ->get();

       return response( [ 'order'=> $orders ], 201 );
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
}

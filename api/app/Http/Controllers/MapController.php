<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MapController extends Controller
{

    public function getSalesMarkers(Request $request, $businessId){
        if($request->filter == "types"){
            $orders = Order::where('orders.business_id', $businessId)
            ->join('customers','customers.id','orders.customer_id')
            ->join('customer_types','customer_types.id','customers.customer_type_id')
            ->select('orders.id','orders.lng', 'orders.lat', 'customer_types.name','customer_types.color')
            ->get();
        }else{
            $orders = Order::where('products.business_id', $businessId)
            ->join('order_products','orders.id','order_products.order_id')
            ->join('products','products.id','order_products.product_id')
            ->select('orders.id','orders.lng', 'orders.lat', 'products.name','products.color')
            ->get();
        }
     

        $orderMod =$orders->map(function ($order) {
                      return [
                          'id' => $order->id,
                          'lngLat' => [(float)$order->lng, (float)$order->lat],
                          'title'=> $order->name,
                          'color'=>$order->color
                      ];
         });
          
          
        return response()->json( $orderMod );
    }
    //
    // public function getSalesMarkers($businessId, $userId) {
    //     //filter by business id
          
    //       if($userId == 0){
    //         //query all visitations based on business id
    //       $custVisits = CustomerVisit::with('customers.customer_types')
    //       ->where('business_id', $businessId)
    //       ->get();
    //       }else{
    //            //query based on user id
    //       $custVisits = CustomerVisit::with('customers.customer_types')
    //       ->where('user_id', $userId)
    //       ->where('business_id', $businessId)
    //       ->get();
    //       }
         
  
    //       $custVisitsModified =$custVisits->map(function ($custVisit) {
    //           return [
    //               'id' => $custVisit->id,
    //               'lngLat' => [(float)$custVisit->lng, (float)$custVisit->lat],
    //               'title'=> $custVisit->customers->customer_types->name,
    //           ];
    //       });
  
  
    //       return response()->json( $custVisitsModified );
    //   }
}

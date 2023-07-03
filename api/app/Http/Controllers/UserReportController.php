<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserReportController extends Controller {
    //TODO filters by dates

    public function getUserReports(Request $request, $userId,$businessId, ) {


        $formatedFilter = "";

        if($request->filter == "today"){
           $dayFilter = [Carbon::now()->startOfDay(),Carbon::now()->endOfDay()];
           $formatedFilter = [now()->toDateString(), now()->toDateString()];
        }else if($request->filter == "week"){
            $dayFilter =[ now()->startOfWeek(),  now()->endOfWeek()];
            $formatedFilter = [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()];
         }else if($request->filter == "month"){
            $dayFilter = [now()->startOfMonth(), now()->endOfMonth()];
            $formatedFilter = [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()];
         }

        return response()->json( [
            'day_filter'=>$formatedFilter,
            'total_visits' =>$this->getTotalCustomerVisits( $userId, $dayFilter ),
            'total_num_sales' =>$this->getUserTotalNumSales( $userId,$dayFilter ),
            'total_num_customers' =>$this->getUserTotalNumCustomers( $userId, $dayFilter ),
            'total_num_orders'=>$this->getTotalNumOrders( $userId, $dayFilter),
            'total_revenue'=>$this->getTotalRevenue( $userId, $dayFilter ),
            'total_credits' =>$this->getTotalCreditAmount( $userId, $dayFilter ),
            'product_sold'=> $this->getUserProductSale($userId,$businessId, $dayFilter),
            'avg_time_spent'=>$this->getAvgTimeSpent($userId, $dayFilter),
            'agent_customers'=>$this->getTopCustomers($userId, $dayFilter)
        ] );
    }

    public function getTotalCustomerVisits( $userId, $dayFilter ) {
        // return $dayFilter;
        $customerVisits =  CustomerVisit::where( 'user_id', $userId )
        ->whereBetween('created_at',$dayFilter)
        ->get();

        return $customerVisits->count();
    }

    public function getUserTotalNumSales( $userId, $dayFilter ) {
        $totalSales = Order::where( 'status', 2 )
        ->whereBetween('created_at', $dayFilter)
        ->where( 'user_id', $userId )
        ->get();

        return $totalSales->count();

    }

    public function getUserTotalNumCustomers( $userId, $dayFilter ) {
        $totalCustomer = Customer::where( 'user_id', $userId )
        ->whereBetween('created_at', $dayFilter)
        ->get();

        return $totalCustomer->count();
    }

    public function getTotalNumOrders( $userId, $dayFilter ) {
        $totalOrders = Order::where( 'status', 1 )
        ->whereBetween('created_at', $dayFilter)
        ->where( 'user_id', $userId )
        ->get();

        return $totalOrders->count();
    }

    public function getTotalRevenue( $userId, $dayFilter ) {
        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.user_id',  $userId )
        ->whereBetween('orders.created_at', $dayFilter)
        ->where( 'orders.status', 2 )
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getTotalCreditAmount( $userId, $dayFilter ) {
        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.user_id',  $userId )
        ->whereBetween('orders.created_at', $dayFilter)
        ->where( 'orders.status', 3 )
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getUserProductSale($userId,$businessId,$dayFilter){
        //get products that user has sold
        $topProducts =DB::table('order_products')
        ->join('orders','orders.id','order_products.order_id')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->where('orders.user_id', $userId)
        ->where('products.business_id', $businessId)
        ->whereBetween('orders.created_at', $dayFilter)
        ->select('order_products.product_id', 'products.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'))
        ->groupBy('order_products.product_id', 'products.name')
        ->orderByDesc('total_quantity')
        ->get();

        $data = [];
        $categories =[];

        foreach($topProducts as $topProduct){
            array_push($data, $topProduct->total_quantity);
            array_push($categories, $topProduct->name);
        }

        
        return ['categories'=>$categories, 'data'=> $data];
    }

    public function getAvgTimeSpent($userId, $dayFilter){
        $avgTime = DB::table('customer_visits')
        ->whereBetween('created_at', $dayFilter)
        ->where('user_id', $userId)
        ->select('time_spent')
        ->get();

        
        $timeSpentValues = $avgTime->pluck('time_spent')->map(function ($value) {
            return (int)$value;
        });

        $average = $timeSpentValues->avg();

        return (int)$average;
    } 


    public function getTopCustomers($userId, $dayFilter){
        $topProducts =DB::table('order_products')
        ->where('orders.user_id', $userId)
        ->whereBetween('orders.created_at', $dayFilter)
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->join('orders','orders.id','order_products.order_id')
        ->join('customers','customers.id','orders.customer_id')
        ->select('customers.id', 'customers.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'), DB::raw('SUM(order_products.total_amount) as total_amount'))
        ->groupBy( 'customers.id','customers.name')
        ->orderByDesc('total_quantity')
        ->get();
    
        $data = [];
        foreach($topProducts as $topProduct){
            $customerVIsit = CustomerVisit::where('customer_id', $topProduct->id)->get();
        
           array_push($data,["id"=>$topProduct->id,"name"=>$topProduct->name, "total_quantity"=>$topProduct->total_quantity, "total_amount"=>$topProduct->total_amount, "total_visits"=>count($customerVIsit)]);
        }
        return $data;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function getReports( $businessId ) {
        return [
            'customer_visit'=> [
                'this_month'=>$this->getCustomerVisits( $businessId ),
                'last_month'=>$this->getCustomerVisitsLastMonth( $businessId )
            ],
            'sales'=>[
                'this_month'=>$this->getSales( $businessId ),
                'last_month'=>$this->getSalesLastMonth(($businessId))
            ],
            'revenue'=>[
                'this_month'=>$this->getRevenue( $businessId ),
                'last_month'=>$this->getRevenueLastMonth($businessId)
            ],
            'new_customers_revenue'=>[
                'this_month'=>$this->getNewCustomersRevenue( $businessId ),
                'last_month'=>$this->getCustomerVisitsLastMonth($businessId)
            ],
            'charts'=>[
                'sales_vs_visits'=>[
                    'sales'=>$this->getDailySales($businessId),
                    'visits'=>$this->getDailyVisits($businessId)
                ],
                'top_products'=>$this->getTopProducts($businessId)
            ]
        ];
    }

    public function getCustomerVisits( $businessId ) {
        $lastMonth = Carbon::now();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');

        $visits = DB::table( 'customer_visits' )
        ->where( 'business_id', $businessId )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();
        return $visits->count();
    }

    public function getCustomerVisitsLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');
        
        $visits = DB::table( 'customer_visits' )
        ->where( 'business_id', $businessId )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();

        return $visits->count();
    }
    

    public function getSales( $businessId ) {
        $lastMonth = Carbon::now();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');

        $sales = Order::where( 'business_id', $businessId )
        ->where( 'status', 2 )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();

        return $sales->count();
    }

    public function getSalesLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');


        $sales = Order::where( 'business_id', $businessId )
        ->where( 'status', 2 )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();

        return $sales->count();
    }

    public function getRevenue( $businessId ) {
        $lastMonth = Carbon::now();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');

        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.business_id', $businessId )
        ->whereBetween( 'orders.created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getRevenueLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format('Y-m-d H:i:s');
        $lastMonthEnd = $lastMonth->endOfMonth()->format('Y-m-d H:i:s');

        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.business_id', $businessId )
        ->whereBetween( 'orders.created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getNewCustomersRevenue( $businessId ) {
        $currentMonth = Carbon::now()->format( 'Y-m' );

        // Get new customers created this month
        $newCustomers = Customer::where( 'created_at', 'like', $currentMonth . '%' )->get();

        // Calculate revenue for new customers
        $newCustomersRevenue = 0;

        foreach ( $newCustomers as $customer ) {
            $orders = Order::where( 'customer_id', $customer->id )->get();

            foreach ( $orders as $order ) {
                $orderProducts = OrderProduct::where( 'order_id', $order->id )->get();

                foreach ( $orderProducts as $orderProduct ) {
                    $newCustomersRevenue += $orderProduct->total_amount;
                }
            }
        }

        // Calculate revenue for all customers
        $allCustomersRevenue = 0;

        $allCustomers = Customer::all();

        foreach ( $allCustomers as $customer ) {
            $orders = Order::where( 'customer_id', $customer->id )->get();

            foreach ( $orders as $order ) {
                $orderProducts = OrderProduct::where( 'order_id', $order->id )->get();

                foreach ( $orderProducts as $orderProduct ) {
                    $allCustomersRevenue += $orderProduct->total_amount;
                }
            }
        }

        // Calculate the percentage contributed by new customers
        if ( $allCustomersRevenue > 0 ) {
            $percentage = ( $newCustomersRevenue / $allCustomersRevenue ) * 100;
        } else {
            $percentage = 0;
        }

        return $percentage;
    }
    public function getNewCustomersRevenueLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth()->format( 'Y-m' );

        // Get new customers created this month
        $newCustomers = Customer::where( 'created_at', 'like', $lastMonth . '%' )->get();

        // Calculate revenue for new customers
        $newCustomersRevenue = 0;

        foreach ( $newCustomers as $customer ) {
            $orders = Order::where( 'customer_id', $customer->id )->get();

            foreach ( $orders as $order ) {
                $orderProducts = OrderProduct::where( 'order_id', $order->id )->get();

                foreach ( $orderProducts as $orderProduct ) {
                    $newCustomersRevenue += $orderProduct->total_amount;
                }
            }
        }

        // Calculate revenue for all customers
        $allCustomersRevenue = 0;

        $allCustomers = Customer::all();

        foreach ( $allCustomers as $customer ) {
            $orders = Order::where( 'customer_id', $customer->id )->get();

            foreach ( $orders as $order ) {
                $orderProducts = OrderProduct::where( 'order_id', $order->id )->get();

                foreach ( $orderProducts as $orderProduct ) {
                    $allCustomersRevenue += $orderProduct->total_amount;
                }
            }
        }

        // Calculate the percentage contributed by new customers
        if ( $allCustomersRevenue > 0 ) {
            $percentage = ( $newCustomersRevenue / $allCustomersRevenue ) * 100;
        } else {
            $percentage = 0;
        }

        return $percentage;
    }

    //create sales 
    public function getDailySales($businessId)
    {
        $sales = Order::where('business_id', $businessId)->currentMonth()->get();
    
    
        // Calculate total sales for each day of the month
        $salesByDay = $sales->groupBy(function ($sale) {
            return $sale->created_at->format('Y-m-d');
        })->map(function ($group) {
            return $group->count('id');
        });

        $data = [];
        $categories =[];

        foreach($salesByDay as $category => $dailySale){
          
            array_push($data, $dailySale);
            array_push($categories, $category);
        }

        
    return ['categories'=>$categories, 'data'=> $data];
   
    }

    //create visits
    public function getDailyVisits($businessId){
        $visits = CustomerVisit::where('business_id', $businessId)->currentMonth()->get();
    
        // Calculate total sales for each day of the month
        $visitByDays = $visits->groupBy(function ($visit) {
            return $visit->created_at->format('Y-m-d');
        })->map(function ($group) {
            return $group->count('id');
        });

        $data = [];
        $categories =[];

        foreach($visitByDays as $actegory => $dailySale){
          
            array_push($data, $dailySale);
            array_push($categories, $actegory);
        }

        return ['categories'=>$categories, 'data'=> $data];
    }   

    public function getTopProducts($businessId){
        $topProducts =DB::table('order_products')
        ->where('products.business_id', $businessId)
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->select('order_products.product_id', 'products.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'))
        ->groupBy('order_products.product_id', 'products.name')
        ->orderByDesc('total_quantity')
        ->limit(6) // Adjust the number of products you want to retrieve
        ->get();

        $data = [];
        foreach($topProducts as $topProduct){
           array_push($data,[$topProduct->name, $topProduct->total_quantity]);
        }
        return $data;
    }
}

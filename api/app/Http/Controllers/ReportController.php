<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Region;
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
                'top_products'=>$this->getTopProducts($businessId),
                'team_sales_vs_visits'=>[
                    'visits'=>$this->getTeamVisits($businessId),
                    'sales'=>$this->getTeamSales($businessId)
                ],
                'top_customer_types'=>$this->getTopCustomerTypes($businessId),
                // 'top_disctricts'=>$this->getTopDisticts($businessId)
            ],
            'data'=>[
                'top_customers'=>$this->getTopCustomers($businessId),
                'top_teams'=>$this->getTopTeams($businessId)
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
        ->where('orders.status', 2)
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

    public function getTeamSales($businessId)
    {
    
        $sales = Order::where('orders.business_id', $businessId)
        ->currentMonth()
        ->join('users', 'users.id', 'orders.user_id')
        ->join('team_users', 'users.id', 'team_users.user_id')
        ->join('teams', 'teams.id', 'team_users.team_id')
        ->groupBy('teams.id','teams.name','users.id')
        ->where('orders.status',2 )
        ->select('teams.id', 'teams.name as team','users.id as user_id', DB::raw('COUNT(orders.id) as sales_count'))
        ->get();

        $data = [];
        $categories =[];

        foreach($sales as $sale){
            array_push($data, $sale->sales_count);
            array_push($categories, $sale->team);
        }
    

        
    return ['categories'=>$categories, 'data'=> $data];
   
    }

    public function getTeamVisits($businessId)
    {
    
        $visits = CustomerVisit::where('customer_visits.business_id', $businessId)
        ->currentMonth()
        ->join('users', 'users.id', 'customer_visits.user_id')
        ->join('team_users', 'users.id', 'team_users.user_id')
        ->join('teams', 'teams.id', 'team_users.team_id')
        ->groupBy('teams.id','teams.name','users.id')
        ->select('teams.id', 'teams.name as team','users.id as user_id', DB::raw('COUNT(customer_visits.id) as visit_count'))
        ->get();

        $data = [];
        $categories =[];

        foreach($visits as $visit){
            array_push($data, $visit->visit_count);
            array_push($categories, $visit->team);
        }

        
        return ['categories'=>$categories, 'data'=> $data];
   
    }

    public function getTopCustomers($businessId){
        $topProducts =DB::table('order_products')
        ->where('products.business_id', $businessId)
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->join('orders','orders.id','order_products.order_id')
        ->join('customers','customers.id','orders.customer_id')
        ->select('customers.id', 'customers.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'), DB::raw('SUM(order_products.total_amount) as total_amount'))
        ->groupBy( 'customers.id','customers.name')
        ->orderByDesc('total_quantity')
        ->limit(6) 
        ->get();
    
        $data = [];
        foreach($topProducts as $topProduct){
            $customerVIsit = CustomerVisit::where('customer_id', $topProduct->id)->get();
        
           array_push($data,["id"=>$topProduct->id,"name"=>$topProduct->name, "total_quantity"=>$topProduct->total_quantity, "total_amount"=>$topProduct->total_amount, "total_visits"=>count($customerVIsit)]);
        }
        return $data;
    }

    public function getTopCustomerTypes($businessId){
        $topProducts =DB::table('order_products')
        ->where('products.business_id', $businessId)
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->join('orders','orders.id','order_products.order_id')
        ->join('customers','customers.id','orders.customer_id')
        ->join('customer_types','customer_types.id','customers.customer_type_id')
        ->select('customer_types.id', 'customer_types.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'), DB::raw('SUM(order_products.total_amount) as total_amount'))
        ->groupBy( 'customer_types.id','customer_types.name')
        ->orderByDesc('total_quantity')
        ->limit(6) 
        ->get();
    
        $data = [];
        foreach($topProducts as $topProduct){
           array_push($data,[$topProduct->name, $topProduct->total_quantity]);
        }
        return $data;
    }

    public function getTopTeams($businessId){
        $topProducts =DB::table('order_products')
        ->where('products.business_id', $businessId)
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->join('orders','orders.id','order_products.order_id')
        ->join('users','users.id','orders.user_id')
        ->join('team_users','users.id','team_users.user_id')
        ->join('teams','teams.id','team_users.team_id')
        ->select('teams.id', 'teams.name', DB::raw('SUM(order_products.total_quantity) as total_quantity'), DB::raw('SUM(order_products.total_amount) as total_amount'))
        ->groupBy( 'teams.id','teams.name')
        ->orderByDesc('total_quantity')
        ->limit(6)
        ->get();
    
        $data = [];
        foreach($topProducts as $topProduct){
            $customerVIsit = CustomerVisit::where('customer_id', $topProduct->id)->get();
        
           array_push($data,["id"=>$topProduct->id,"name"=>$topProduct->name, "total_quantity"=>$topProduct->total_quantity, "total_amount"=>$topProduct->total_amount, "total_visits"=>count($customerVIsit)]);
        }
        return $data;
    }

    public function getTopDisticts($businessId){
        $regions = DB::table('regions')
        ->join('districts', 'regions.id', '=', 'districts.region_id')
        ->join('customers', 'districts.id', '=', 'customers.district_id')
        ->join('orders', 'customers.id', '=', 'orders.customer_id')
        ->join('order_products', 'orders.id', '=', 'order_products.order_id')
        ->select('regions.name as region_name', 'districts.name as district_name', DB::raw('SUM(order_products.total_quantity) as total_quantity_sold'))
        ->groupBy('regions.id', 'regions.name', 'districts.id', 'districts.name')
        ->orderBy('regions.name', 'asc')
        ->orderBy('total_quantity_sold', 'desc')
        ->get();
    
    $result = [];
    
    foreach ($regions as $region) {
        $result[$region->region_name][] = [
            'name' => $region->district_name,
            'value' => $region->total_quantity_sold,
        ];
    }
    
    $finalResult = [];
    
    foreach ($result as $regionName => $districts) {
        $finalResult[] = [
            'name' => $regionName,
            'data' => $districts,
        ];
    }
    

       return $finalResult;
    }
}

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
use Illuminate\Http\Request;

class ReportController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function getReports( Request $request, $businessId ) {
        $formatedFilter = '';

        if ( $request->filter == 'today' ) {
            $dayFilter = [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ];
            $formatedFilter = [ now()->toDateString(), now()->toDateString() ];
        } else if ( $request->filter == 'week' ) {
            $dayFilter = [ now()->startOfWeek(),  now()->endOfWeek() ];
            $formatedFilter = [ now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString() ];
        } else if ( $request->filter == 'month' ) {
            $dayFilter = [ now()->startOfMonth(), now()->endOfMonth() ];
            $formatedFilter = [ now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString() ];
        }

        // return[

        //     $this->getTodaySalesTrend( $businessId )
        // ];
        return [
            'customer_visit'=> [
                'this_month'=>$this->getCustomerVisits( $businessId, $dayFilter ),
                'last_month'=>$this->getCustomerVisitsLastMonth( $businessId )
            ],
            'sales'=>[
                'this_month'=>$this->getSales( $businessId, $dayFilter ),
                'last_month'=>$this->getSalesLastMonth( $businessId )
            ],
            'revenue'=>[
                'this_month'=>$this->getRevenue( $businessId, $dayFilter ),
                'last_month'=>$this->getRevenueLastMonth( $businessId )
            ],
            'new_customers_revenue'=>[
                'this_month'=>$this->getNewCustomersRevenue( $businessId ),
                // 'last_month'=>$this->getCustomerVisitsLastMonth( $businessId, $dayFilter )
            ],
            'charts'=>[
                'sales_vs_visits'=>[
                    'sales'=>$this->getDailySalesVsVisits( $businessId, $dayFilter, $request->filter ),
                ],
                'top_products'=>$this->getTopProducts( $businessId, $dayFilter ),
                'team_sales_vs_visits'=>[
                    'visits'=>$this->getTeamVisits( $businessId, $dayFilter ),
                    'sales'=>$this->getTeamSales( $businessId, $dayFilter )
                ],
                'top_customer_types'=>$this->getTopCustomerTypes( $businessId, $dayFilter ),
                'top_disctricts'=>$this->getTopDisticts( $businessId, $dayFilter )
            ],
            'data'=>[
                'top_customers'=>$this->getTopCustomers( $businessId, $dayFilter ),
                'top_teams'=>$this->getTopTeams( $businessId, $dayFilter )
            ],
            'sales_trend'=>$this->getSalesTrend( $businessId, $dayFilter, $request->filter )
        ];
    }

    public function getCustomerVisits( $businessId, $dayFilter ) {

        $visits = DB::table( 'customer_visits' )
        ->where( 'business_id', $businessId )
        ->whereBetween( 'created_at', $dayFilter )
        ->get();
        return $visits->count();
    }

    public function getCustomerVisitsLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format( 'Y-m-d H:i:s' );
        $lastMonthEnd = $lastMonth->endOfMonth()->format( 'Y-m-d H:i:s' );

        $visits = DB::table( 'customer_visits' )
        ->where( 'business_id', $businessId )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();

        return $visits->count();
    }

    public function getSales( $businessId, $dayFilter ) {

        $sales = Order::where( 'business_id', $businessId )
        ->where( 'status', 2 )
        ->whereBetween( 'created_at', $dayFilter )
        ->get();

        return $sales->count();
    }

    public function getSalesLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format( 'Y-m-d H:i:s' );
        $lastMonthEnd = $lastMonth->endOfMonth()->format( 'Y-m-d H:i:s' );

        $sales = Order::where( 'business_id', $businessId )
        ->where( 'status', 2 )
        ->whereBetween( 'created_at', [ $lastMonthStart, $lastMonthEnd ] )
        ->get();

        return $sales->count();
    }

    public function getRevenue( $businessId, $dayFilter ) {

        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.business_id', $businessId )
        ->where( 'orders.status', 2 )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getRevenueLastMonth( $businessId ) {
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->startOfMonth()->format( 'Y-m-d H:i:s' );
        $lastMonthEnd = $lastMonth->endOfMonth()->format( 'Y-m-d H:i:s' );

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

    public function getNewCustomersRevenueLastMonth( $businessId, $dayFilter ) {
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

    public function getDailySalesVsVisits( $businessId, $dayFilter, $requestFilter ) {
        if ( $requestFilter == 'today' ) {
            return $this->getDailySalesVsVisitsByTime( $businessId );
        }

        return $this->getDailySalesVsVisitsByFilter( $businessId, $dayFilter );
    }

    public function getDailySalesVsVisitsByFilter( $businessId, $dayFilter ) {

        $orders = Order::where( 'orders.business_id', $businessId )
        ->select( DB::raw( 'DATE(orders.created_at) AS date' ),
        DB::raw( 'COUNT(DISTINCT orders.id) AS order_count' ) )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->groupBy( 'date' )
        ->get();

        $customerVisits = CustomerVisit::where( 'business_id', $businessId )
        ->select( DB::raw( 'DATE(created_at) AS date' ),
        DB::raw( 'COUNT(DISTINCT id) AS visit_count' ) )
        ->groupBy( 'date' )
        ->whereBetween( 'customer_visits.created_at', $dayFilter )
        ->get();

        // Merge the results and create order counts and visit counts for matching dates
        $results = [];

        foreach ( $orders as $order ) {
            $results[ $order->date ] = [
                'order_count' => $order->order_count,
                'visit_count' => 0,
            ];
        }

        foreach ( $customerVisits as $visit ) {
            if ( isset( $results[ $visit->date ] ) ) {
                $results[ $visit->date ][ 'visit_count' ] = $visit->visit_count;
            } else {
                $results[ $visit->date ] = [
                    'order_count' => 0,
                    'visit_count' => $visit->visit_count,
                ];
            }
        }

        // Prepare the data in the requested format
        $visits = [
            'categories' => [],
            'data' => [],
        ];

        foreach ( $results as $date => $counts ) {
            $visits[ 'categories' ][] = $date;
            $visits[ 'data' ][] = $counts[ 'visit_count' ];
        }

        $ordersData = [
            'categories' => [],
            'data' => [],
        ];

        foreach ( $results as $date => $counts ) {
            $ordersData[ 'categories' ][] = $date;
            $ordersData[ 'data' ][] = $counts[ 'order_count' ];
        }

        return [ 'categories'=>$ordersData[ 'categories' ], 'visits'=> $visits[ 'data' ], 'sales'=>$ordersData[ 'data' ] ];

    }

    public function getDailySalesVsVisitsByTime( $businessId ) {
        $orders = Order::where( 'orders.business_id', $businessId )
        ->select( DB::raw( 'HOUR(orders.created_at) AS hour' ),
        DB::raw( 'COUNT(DISTINCT orders.id) AS order_count' ) )
        ->whereBetween( 'orders.created_at', [ [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ] ] )
        ->groupBy( 'hour' )
        ->get();

        // return $orders;
        $customerVisits = CustomerVisit::where( 'business_id', $businessId )
        ->select( DB::raw( 'HOUR(created_at) AS hour' ),
        DB::raw( 'COUNT(DISTINCT id) AS visit_count' ) )
        ->whereBetween( 'customer_visits.created_at', [ [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ] ] )
        ->groupBy( 'hour' )
        ->get();

        $results = [];
        $hoursInDay = 24;

        for ( $i = 0; $i < $hoursInDay; $i++ ) {
            $results[ $i ] = [
                'order_count' => 0,
                'visit_count' => 0,
            ];
        }

        foreach ( $orders as $order ) {
            $results[ $order->hour ][ 'order_count' ] = $order->order_count;
        }

        foreach ( $customerVisits as $visit ) {
            $results[ $visit->hour ][ 'visit_count' ] = $visit->visit_count;
        }

        $visits = [
            'categories' => [],
            'data' => [],
        ];

        $ordersData = [
            'categories' => [],
            'data' => [],
        ];

        for ( $i = 0; $i < $hoursInDay; $i++ ) {
            $formattedTime = ( $i % 12 == 0 ) ? 12 : $i % 12;
            $amPm = $i < 12 ? 'am' : 'pm';

            $visits[ 'categories' ][] = $formattedTime . ' ' . $amPm;
            $visits[ 'data' ][] = $results[ $i ][ 'visit_count' ];

            $ordersData[ 'categories' ][] = $formattedTime . ' ' . $amPm;
            $ordersData[ 'data' ][] = $results[ $i ][ 'order_count' ];
        }

        return [
            'categories' => $ordersData[ 'categories' ],
            'visits' => $visits[ 'data' ],
            'sales' => $ordersData[ 'data' ],
        ];

    }

    public function getTopProducts( $businessId, $dayFilter ) {

        $topProducts = DB::table( 'order_products' )
        ->where( 'products.business_id', $businessId )
        ->join( 'orders', 'orders.id', 'order_products.order_id' )
        ->join( 'products', 'order_products.product_id', '=', 'products.id' )
        ->select( 'order_products.product_id', 'products.name', DB::raw( 'SUM(order_products.total_quantity) as total_quantity' ) )
        ->groupBy( 'order_products.product_id', 'products.name' )
        ->orderByDesc( 'total_quantity' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->limit( 3 ) // Adjust the number of products you want to retrieve
        ->get();

        $data = [];
        foreach ( $topProducts as $topProduct ) {
            array_push( $data, [ $topProduct->name, $topProduct->total_quantity ] );
        }
        return $data;
    }

    public function getTeamSales( $businessId, $dayFilter ) {

        $sales = Order::where( 'teams.business_id', $businessId )
        ->currentMonth()
        ->join( 'users', 'users.id', 'orders.user_id' )
        ->join( 'team_users', 'users.id', 'team_users.user_id' )
        ->join( 'teams', 'teams.id', 'team_users.team_id' )
        ->groupBy( 'teams.id', 'teams.name' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->where( 'orders.status', 2 )
        ->select( 'teams.id', 'teams.name as team', DB::raw( 'COUNT(orders.id) as sales_count' ) )
        ->get();

        $data = [];
        $categories = [];

        foreach ( $sales as $sale ) {
            array_push( $data, $sale->sales_count );
            array_push( $categories, $sale->team );
        }

        return [ 'categories'=>$categories, 'data'=> $data ];

    }

    public function getTeamVisits( $businessId, $dayFilter ) {

        $visits = CustomerVisit::where( 'teams.business_id', $businessId )
        ->currentMonth()
        ->join( 'users', 'users.id', 'customer_visits.user_id' )
        ->join( 'team_users', 'users.id', 'team_users.user_id' )
        ->join( 'teams', 'teams.id', 'team_users.team_id' )
        ->groupBy( 'teams.id', 'teams.name' )
        ->whereBetween( 'customer_visits.created_at', $dayFilter )
        ->select( 'teams.id', 'teams.name as team', DB::raw( 'COUNT(customer_visits.id) as visit_count' ) )
        ->get();

        $data = [];
        $categories = [];

        foreach ( $visits as $visit ) {
            array_push( $data, $visit->visit_count );
            array_push( $categories, $visit->team );
        }

        return [ 'categories'=>$categories, 'data'=> $data ];

    }

    public function getTopCustomers( $businessId, $dayFilter ) {
        $topProducts = DB::table( 'order_products' )
        ->where( 'customer_visits.business_id', $businessId )
        ->join( 'products', 'order_products.product_id', '=', 'products.id' )
        ->join( 'orders', 'orders.id', 'order_products.order_id' )
        ->join( 'customers', 'customers.id', 'orders.customer_id' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->join( 'customer_visits', 'customers.id', 'customer_visits.customer_id' )
        ->select( 'customers.id', 'customers.name', DB::raw( 'SUM(order_products.total_quantity) as total_quantity' ), DB::raw( 'SUM(order_products.total_amount) as total_amount' ) )
        ->groupBy( 'customers.id', 'customers.name' )
        ->orderByDesc( 'total_quantity' )
        ->limit( 6 )
        ->get();

        $data = [];
        foreach ( $topProducts as $topProduct ) {
            $customerVIsit = CustomerVisit::where( 'customer_id', $topProduct->id )
            ->where( 'business_id', $businessId )->get();

            array_push( $data, [ 'id'=>$topProduct->id, 'name'=>$topProduct->name, 'total_quantity'=>$topProduct->total_quantity, 'total_amount'=>$topProduct->total_amount, 'total_visits'=>count( $customerVIsit ) ] );
        }
        return $data;
    }

    public function getTopCustomerTypes( $businessId, $dayFilter ) {
        $customerTypes = DB::table( 'order_products' )
        ->where( 'orders.business_id', $businessId )
        // ->join( 'products', 'order_products.product_id', '=', 'products.id' )
        ->join( 'orders', 'orders.id', 'order_products.order_id' )
        ->join( 'customers', 'customers.id', 'orders.customer_id' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->join( 'customer_types', 'customer_types.id', 'customers.customer_type_id' )
        ->select( 'customer_types.id', 'customer_types.name', DB::raw( 'SUM(order_products.total_quantity) as total_quantity' ), DB::raw( 'SUM(order_products.total_amount) as total_amount' ) )
        ->groupBy( 'customer_types.id', 'customer_types.name' )
        ->orderByDesc( 'total_quantity' )
        ->limit( 6 )
        ->get();

        $data = [];
        foreach ( $customerTypes as $customerType ) {
            array_push( $data, [ $customerType->name, $customerType->total_quantity ] );
        }
        return $data;
    }

    public function getTopTeams( $businessId, $dayFilter ) {
        $topProducts = DB::table( 'order_products' )
        ->where( 'teams.business_id', $businessId )
        ->join( 'products', 'order_products.product_id', '=', 'products.id' )
        ->join( 'orders', 'orders.id', 'order_products.order_id' )
        ->join( 'users', 'users.id', 'orders.user_id' )
        ->join( 'team_users', 'users.id', 'team_users.user_id' )
        ->join( 'teams', 'teams.id', 'team_users.team_id' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->select( 'teams.id', 'teams.name', DB::raw( 'SUM(order_products.total_quantity) as total_quantity' ), DB::raw( 'SUM(order_products.total_amount) as total_amount' ) )
        ->groupBy( 'teams.id', 'teams.name' )
        ->orderByDesc( 'total_quantity' )
        ->limit( 6 )
        ->get();

        $data = [];
        foreach ( $topProducts as $topProduct ) {
            // echo ''.$topProduct->customer_id;
            $customerVIsit = CustomerVisit::where( 'business_id', $businessId )
            ->get();

            array_push( $data, [ 'id'=>$topProduct->id, 'name'=>$topProduct->name, 'total_quantity'=>$topProduct->total_quantity, 'total_amount'=>$topProduct->total_amount, 'total_visits'=>count( $customerVIsit ) ] );
        }
        return $data;
    }

    public function getTopDisticts( $businessId, $dayFilter ) {
        $regions = DB::table( 'regions' )
        ->join( 'districts', 'regions.id', '=', 'districts.region_id' )
        ->join( 'customers', 'districts.id', '=', 'customers.district_id' )
        ->join( 'orders', 'customers.id', '=', 'orders.customer_id' )
        ->join( 'order_products', 'orders.id', '=', 'order_products.order_id' )
        ->select( 'regions.name as region_name', 'districts.name as district_name', DB::raw( 'SUM(order_products.total_quantity) as total_quantity_sold' ) )
        ->groupBy( 'regions.id', 'regions.name', 'districts.id', 'districts.name' )
        ->orderBy( 'regions.name', 'asc' )
        ->orderBy( 'total_quantity_sold', 'desc' )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->get();

        $result = [];

        foreach ( $regions as $region ) {
            $result[ $region->region_name ][] = [
                'name' => $region->district_name,
                'value' => $region->total_quantity_sold,
            ];
        }

        $finalResult = [];

        foreach ( $result as $regionName => $districts ) {
            $finalResult[] = [
                'name' => $regionName,
                'data' => $districts,
            ];
        }

        return $finalResult;
    }

    public function getSalesTrend( $businessId, $dayFilter, $requestFilter) {
            if ( $requestFilter == 'today' ) {
                return $this->getTodaySalesTrend( $businessId );
            }


           return $this->getSalesTrendByFilter($businessId, $dayFilter);

    }

    public function getSalesTrendByFilter($businessId, $dayFilter){
        
        $salesData = Order::join( 'order_products', 'orders.id', '=', 'order_products.order_id' )
        ->join( 'products', 'products.id', '=', 'order_products.product_id' )
        ->where( 'products.business_id', $businessId )
        ->where( 'orders.status', 2 )
        ->whereBetween( 'orders.created_at', $dayFilter )
        ->select(
            DB::raw( 'COUNT(DISTINCT products.id) as product_count' ),
            DB::raw( 'SUM(order_products.total_quantity ) as total_quantity' ),
            DB::raw( 'DAYOFWEEK(orders.created_at) as day_of_week' ),
            DB::raw( 'MAX(products.name) as product_name' )
        )
        ->groupBy( 'day_of_week', 'products.id' )
        ->get();

        $series = [];
        $colors = [ '#61c3fe','#ff6600','#006699', '#ff6600', '#99cc33', '#990066', '#ff6600', '#fb4e4f' ];

        foreach ( $salesData as $index => $sale ) {
            $productName = $sale->product_name;
            $productCount = $sale->total_quantity;
            $dayOfWeek = $sale->day_of_week - 1;

            $series[] = [
                'name' => $productName,
                'data' => array_fill( 0, 7, 0 ), // Initialize the data array with zeros for all days of the week
                'color' => $colors[ $index % count( $colors ) ] // Assign a color from the array based on the index
            ];

            $seriesIndex = count( $series ) - 1;
            $series[ $seriesIndex ][ 'data' ][ $dayOfWeek ] = $productCount;

        }

        return [ 'categories'=> [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ], 'data'=> $series ];
    }

    public function getTodaySalesTrend( $businessId ) {
        $salesData = Order::join( 'order_products', 'orders.id', '=', 'order_products.order_id' )
        ->join( 'products', 'products.id', '=', 'order_products.product_id' )
        ->where( 'products.business_id', $businessId )
        ->where( 'orders.status', 2 )
        ->whereBetween( 'orders.created_at', [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ])
        ->select(
            DB::raw( 'COUNT(DISTINCT products.id) as product_count' ),
            DB::raw( 'SUM(order_products.total_quantity) as total_quantity' ),
            DB::raw( 'HOUR(orders.created_at) as hour_of_day' ),
            DB::raw( 'MAX(products.name) as product_name' )
        )
        ->groupBy( 'hour_of_day', 'products.id' )
        ->get();

        $series = [];
        $colors = [ 'blue', 'red', 'green', 'yellow', 'orange', 'purple', 'pink' ];

        foreach ( $salesData as $index => $sale ) {
            $productName = $sale->product_name;
            $productCount = $sale->total_quantity;
            $hourOfDay = $sale->hour_of_day;

            $formattedHour = ( $hourOfDay % 12 === 0 ) ? 12 : $hourOfDay % 12;
            // Format the hour as 12-hour clock

            $formattedHourLabel = $formattedHour . ( ( $hourOfDay < 12 ) ? ' am' : ' pm' );
            // Add 'am' or 'pm'

            $series[] = [
                'name' => $productName,
                'data' => array_fill( 0, 24, 0 ),
                'color' => $colors[ $index % count( $colors ) ]
            ];

            $seriesIndex = count( $series ) - 1;
            $series[ $seriesIndex ][ 'data' ][ $hourOfDay ] = $productCount;
        }

        return [
            'categories' => array_map( function ( $hour ) {
                $formattedHour = ( $hour % 12 === 0 ) ? 12 : $hour % 12;
                return $formattedHour . ( ( $hour < 12 ) ? ' am' : ' pm' );
            }
            , range( 0, 23 ) ),
            'data' => $series
        ];

    }
}

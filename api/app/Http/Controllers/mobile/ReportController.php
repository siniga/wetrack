<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVisit;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller {
    //status 1 = orders, 2 = sales, 3 = credits

    //TODO:calculate bonus and other kps (sales, visits, revenue)for each sales person and show it to them

    public function getReport() {
        $user = Auth::user();
        return response()->json( [
            'total_visits' =>$this->getTotalCustomerVisits( $user ),
            'total_num_sales' =>$this->getUserTotalNumSales( $user ),
            'total_num_customers' =>$this->getUserTotalNumCustomers( $user ),
            'total_num_orders'=>$this->getTotalNumOrders($user),
            'total_revenue'=>$this->getTotalRevenue($user),
            'total_credits' =>$this->getTotalCreditAmount($user)
        ] );
    }

    public function getTotalCustomerVisits( $user ) {
        $customerVisits =  CustomerVisit::where( 'user_id', $user->id )->get();

        return $customerVisits->count();
    }

    public function getUserTotalNumSales( $user ) {
        $totalSales = Order::where( 'status', 2 )
        ->where( 'user_id', $user->id )
        ->get();

        return $totalSales->count();

    }

    public function getUserTotalNumCustomers( $user ) {
        $totalCustomer = Customer::where( 'user_id', $user->id )
        ->get();

        return $totalCustomer->count();
    }

    public function getTotalNumOrders( $user ) {
        $totalOrders = Order::where( 'status', 1 )
        ->where( 'user_id', $user->id )
        ->get();

        return $totalOrders->count();
    }

    public function getTotalRevenue($user) {
        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.user_id',  $user->id)
        ->where('orders.status',2)
        ->sum( 'total_amount' );

        return $totalAmount;
    }

    public function getTotalCreditAmount($user) {
        $totalAmount = OrderProduct::join( 'orders', 'orders.id', 'order_products.order_id' )
        ->where( 'orders.user_id',  $user->id)
        ->where('orders.status',3)
        ->sum( 'total_amount' );

        return $totalAmount;
    }
}

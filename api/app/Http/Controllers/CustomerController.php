<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\CustomerVisit;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        if ( $customer->save() ) {
            $customer->load( 'customerType' );

            return response()->json( $customer );
        }
    }

    public function update( Request $request ) {
        //
        $customer  = Customer::findOrFail( $request->id );
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

        if ( $customer->save() ) {
            $customer->load( 'customerType' );

            return response()->json( $customer );
        }
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Customer $customer ) {
        //
    }

    public function getCustomersByBusinessId( $businessId ) {
        $customers = Customer::with( 'user', 'districts', 'customer_types' )
        ->where( 'business_id', $businessId )
        ->orderBy( 'id', 'desc' )
        ->get();

        return response()->json( $customers );
    }

    public function getCustomerByUserid() {
        $user = Auth::user();

        $customers = Customer::with( 'user', 'district', 'customer_types' )
        ->where( 'user_id', $user->id )
        ->orderBy( 'id', 'desc' )
        ->get();

        return response()->json( $customers );
    }

    public function insertCustomers() { 
        
      
        //   foreach($orders as $order){
        //     $cs = CustomerVisit::findOrFail(random_int(1,360));
        //     $cs->lat =  $order['lat'];
        //     $cs->lng = $order['lng'];
        //     $cs->save();
        //   }
        // for($i = 1 ; $i < 300; $i++){
        //     $cs = new CustomerVisit;
        //     $cs->time_spent =  random_int( 1, 60 )." minutes";
        //     $cs->purchase_rejection_reason_id = random_int( 1, 7 );
        //     $cs->customer_id = random_int( 50, 200 );
        //     $cs->user_id = random_int( 300, 356 );
        //     $cs->business_id = 2;

        //     $cs->save();
        // }
           
        // foreach ( $products as $item ) {

        //     $orderProduct = new Product;
        //     $orderProduct->name = $item[ 'name' ];
        //     $orderProduct->cost = $item['cost'];
        //     $orderProduct->price = $item['price'];
        //     $orderProduct->stock = 0;
        //     $orderProduct->sku =$item['sku'];
        //     $orderProduct->business_id = 1;
        //     $orderProduct->category_id = 1;
           
        //     $orderProduct->save();
        // }

        // $categories = array(
        //     array('id' => '1','name' => 'Mafuta ya kupaka','color' => '#cccccc','client_id' => '1','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '2','name' => 'Sabuni','color' => '#cccccc','client_id' => '1','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '3','name' => 'Malboro','color' => '#cccccc','client_id' => '2','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '4','name' => 'Lager','color' => '','client_id' => '3','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '5','name' => 'Light','color' => '','client_id' => '3','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '6','name' => 'Cider','color' => '','client_id' => '3','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '7','name' => 'Za kopo (CAN)','color' => '','client_id' => '14','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '8','name' => 'Za Chupa (PET)','color' => '','client_id' => '14','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '9','name' => 'Lotion','color' => '#ccc','client_id' => '1','created_at' => NULL,'updated_at' => NULL),
        //     array('id' => '11','name' => 'Bia','color' => '#f2f2f2','client_id' => '17','created_at' => NULL,'updated_at' => NULL)
        //   );
          
        // foreach ( $order_products as $item ) {

        //     $orderProduct = new OrderProduct;
        //     $orderProduct->order_id = random_int( 6, 50 );;
        //     $orderProduct->product_id = random_int( 1, 20 );;
        //     $orderProduct->total_quantity = $item['quantity'];
        //     $orderProduct->total_amount = $item['total_amount'];
           
        //     $orderProduct->save();
        // }


        // foreach ( $outlets as $item ) {

        //     $district_id;
        //     if($item['location'] == 'Knondoni'){
        //         $district_id  = 8;
        //     }else if($item['location'] == 'Ilala'){
        //         $district_id  = 9;
        //     }else{
        //         $district_id  = 10;
        //     }

        //     $customer = new Customer;
        //     $customer->name = $item[ 'name' ];
        //     $customer->device_time = $item['created_at'];
        //     $customer->phone = $item['phone'];
        //     $customer->created_date = $item['created_at'];
        //     $customer->lat = $item[ 'lat' ];
        //     $customer->lng = $item[ 'lng' ];
        //     $customer->location = $item['location'];
        //     $customer->business_id = 1;
        //     $customer->user_input_address = 'None';
        //     $customer->user_id = 1;
        //     $customer->district_id = $district_id;
        //     $customer->customer_type_id = $item['outlet_type_id'];
        //     $customer->user_id = 1;

        //     $customer->save();
        // }

        // //   foreach ( $users as $item ) {
        // //     $length = 10;
        // Length of the random string
        //     $domain = 'we.com';
        // The domain name for the email addresses

        //     $randomString = Str::random( $length );
        //     $email = $randomString . '@' . $domain;

        //     $user = new User;
        //     $user->name = $item[ 'name' ];
        //     $user->email = $email;
        //     $user->phone = $item[ 'phone' ];
        //     $user->password = $item[ 'password' ];
        //     $user->code = random_int( 1000, 9999 );
        //     $user->business_id = 1;
        //     $user->role = 'agent';
        //     $user->active_status = 1;

        //     $user->save();
        // }

        // Assuming you have already imported the necessary classes at the top of your file
        // Generate an array of 200 rows with randomized 'time_spent' values
        // $rows = [];
        // for ( $i = 1; $i <= 200; $i++ ) {
        //     $timeSpent = rand( 1, 60 ) . ' minutes';
        //     // Randomize the minutes between 1 and 60
        //     $rows[] = array(
        //         'time_spent' => $timeSpent,
        //         'customer_id' => '23',
        //         'user_id' => '4',
        //         'business_id' => '1',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => null,
        // );
        // }

        // Use the 'insert' method provided by Eloquent to insert the rows
        // CustomerVisit::insert( $rows );

        // foreach ( $orders as $item ) {
        //     $customer = new Order;
        //     $customer->status = $item[ 'status' ];
        //     $customer->order_no = $item[ 'order_no' ];
        //     $customer->device_time = $item[ 'device_time' ];
        //     $customer->lat = $item[ 'lat' ];
        //     $customer->lng = $item[ 'lng' ];
        //     $customer->user_id = random_int( 6, 50 );
        //     $customer->customer_id = mt_rand( 1, 256 );
        //     $customer->business_id = 1;

        //     $customer->save();
        // }
    }
}

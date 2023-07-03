<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    //

    public function register( Request $request ) {
        $fields = $request->validate( [
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'name' => 'required:string',
            'phone' => 'required:string',
            'code'=>'required:string',
            'business_id'=> 'required:integer'
        ] );

        $user = User::create( [
            'email'=>$fields[ 'email' ],
            'password'=>bcrypt( $fields[ 'password' ] ),
            'name' => $fields[ 'name' ],
            'phone' => $fields[ 'phone' ],
            'role' => 'admin',
            'code'=> $fields[ 'code' ],
            'business_id'=> $fields[ 'business_id' ],
            'active_status' => 1
        ] );

        $token = $user->createToken( 'wetrack' )->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response( $response, 201 );
    }

    public function login( Request $request ) {

       
        //if email is set allow user to login with email
        //otherwise allow user to login with phone number

        $fields = $request->validate( [
            'email'=>'required|string',
            'password'=>'required|string'
        ] );

        //get user where email is equal to requested email
        $user = User::where( 'email', $fields[ 'email' ] )
        ->join( 'businesses', 'users.business_id', 'businesses.id' )
        ->select( 'users.*', 'businesses.name as business_name' )
        ->first();

 
        //check password
        if ( !$user || !Hash::check( $fields[ 'password' ], $user->password ) ) {

            return response( [
                'message' => 'Invalid credentials',
            ], 401 );
        }

        $token = $user->createToken( 'wetrack' )->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response( $response, 201 );
    }

    public function loginWithPhoneNum( Request $request ) {

        //check if phone number exist
        $user = User::where( 'phone_number', '=', $request->phone_number );

        //generate otp
        // $otpDetails = $this->generateOtp();

        $isPhoneExist = $user->exists();
        $userData = $user->with('bussinesses')->first();
        return $user;
        if ( $isPhoneExist ) {
            //update user otp
            // $userData->update( [
            //     'otp' => $otpDetails[ 0 ],
            //     'otp_expires_at' => $otpDetails[ 1 ]
            // ] );

            $token = $userData->createToken( 'authToken' )->plainTextToken;
            return response()->json( [
                'user' =>  $userData ,
                'token' => $token
            ] );

        } else{
            return response()->json(['message'=>'user doesnt exist', 'code'=> 404]);
        }
    }
}

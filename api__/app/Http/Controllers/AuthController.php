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
        ->join( 'businesses', 'users.business_id', '=', 'businesses.id' )
        ->select( 'users.*', 'businesses.name as business_name' )
        ->first();

        //check password
        if ( !$user || !Hash::check( $fields[ 'password' ], $user->password ) ) {

            return response( [
                'message' => 'Invalid credentials',
            ], 401 );
        }

        $token = $user->createToken( 'itargetToken' )->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response( $response, 201 );
    }
}

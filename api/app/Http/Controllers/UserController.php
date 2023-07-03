<?php

namespace App\Http\Controllers;

use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    //

    public function getusers($businessId){
        $users = User::where('business_id', $businessId)
        ->orderBy('id', 'desc')
        ->get();

        return  response()->json($users);
    }

    public function store(Request $request){

        $phoneExist =  User::where('phone', $request->phone)->exists();
        $emailExist =  User::where('email', $request->email)->exists();

        if($phoneExist){
            return response()->json(["message"=>"Phone exists", "error"=>"phoneexist"]); 
        }

        if($emailExist){
            return response()->json(["message"=>"Email exists", "error"=>"emailexist" ]); 
        }

        //TODO:validate data
        $user = new User;
        $user->name = $request->first_name." ".$request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->code = $request->code;
        $user->active_status = $request->active_status;
        $user->business_id = $request->business_id;
        
        if($user->save()){
            return response()->json($user);
        }
    }
    public function update(Request $request, $userId){
        $user = User::findOrFail($userId);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
           if( $user->save()){
            return response()->json($user);
           }
        }
    }

    public function show($id){
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function updatePassword(Request $request){
        $user = Auth::user();
        $currentPassword = $request->currentPassword;
        $newPassword = $request->newPassword;

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    public function assignUserToTeam(Request $request){
      
        foreach ($request->users as $item) {
            DB::table('team_users')->insert($item);
        }

        return response()->json(["message"=>"Users are successfully assigned"]);

    }
    public function getUsersByteamId($businessId, $role) {
        $usersAndTeams = User::where('role', $role)->with(['teams' => function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        }])->orderBy('id', 'desc')->get();

        return response()->json($usersAndTeams);
    }

    
    public function getAgentsByBusinessId($businessId) {
    
        $agents = User::where('role', 'agent')
        ->where('business_id', $businessId)
        ->whereNotIn('id', function ($query) {
            $query->select('user_id')
                ->from('team_users');
        })
        ->orderBy('id', 'desc')
        ->get();

        return response()->json($agents);
    }


    public function getUsersByRoleId($role, $businessId){
        $users = User::where('role', $role)
        ->where('business_id', $businessId)
        ->orderBy('id', 'desc')
        ->get();


       return response()->json($users);
    }

    public function getUsersByRegion($businessId, $regionId){
        $users = User::with('orders')
        ->join('team_users', 'users.id', 'team_users.user_id')
        ->join('teams', 'teams.id', 'team_users.team_id')
        ->where('teams.region_id', $regionId)
        ->where('teams.business_id', $businessId)
        ->where("users.role",'agent')
        ->select('users.id','users.name','users.phone','users.role', 'teams.name as team')
        ->get();

    $usersWithCustomerCount = $users->map(function ($user) {
        $numSales = $user->orders->count(); // Get the count of customers for each user
    
        return [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'phone'=>$user->phone,
            'team'=>$user->team,
            'role'=>$user->role
        ];
    });
        
        return response()->json($usersWithCustomerCount);
    }

    public function getUsersVisits($businessId, $regionId){
        $users = User::with('customer_visits.customers.districts')
        ->join('team_users','users.id','team_users.user_id' )
        ->join('teams','teams.id','team_users.team_id' )
        ->where('teams.business_id', $businessId)
        ->where('teams.region_id', $regionId)
        ->select('users.id','users.name','users.phone', 'teams.name as team')
        ->get();

        $usersMod = $users->map(function($user){
            $numVisits = $user->customer_visits->count(); // Get the count of customers for each user
    
            return [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'num_visits' => $numVisits,
                'phone'=>$user->phone,
                'team'=>$user->team
            ];
        });

        return response()->json($usersMod);
    }
   
}

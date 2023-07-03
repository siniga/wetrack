<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller {
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
        $team =  new Team;
        $team->name =  $request->name;
        $team->business_id = $request->business_id;
        $team->region_id  = $request->region_id;

        if ( $team->save() ) {
            return response()->json( $team );
        }

    }

    /**
    * Display the specified resource.
    */

    public function show( Team $team ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Team $team ) {
        //
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( UpdateTeamRequest $request, Team $team ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Team $team ) {
        //
    }

    public function getTeamsByBusinessId( $businessId ) {
        $teams = Team::with( 'region' )
        ->with( 'users', function($query) {
            // $query->where('role', 'supervisor');
        })
        ->where( 'business_id', $businessId )
        ->orderBy( 'id', 'desc' )
        ->get();
        
        return response()->json( $teams );
    }

    public function assignSupervisor( Request $request ) {
        // Check if the user and team exist

        // Insert the record into the team_users table
        DB::table( 'team_users' )->insert( [
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
        ] );

        return response()->json( [ 'message' => 'User added to team successfully' ] );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    //

    public function getUsersByteamId($businessId, $role) {
        $usersAndTeams = User::where('role', $role)->with(['teams' => function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        }])->get();

        return response()->json($usersAndTeams);
    }
}

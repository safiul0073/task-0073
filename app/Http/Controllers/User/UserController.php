<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(auth()->id());

        $referrals = $user->load('referrals');

        return view("dashboard.referrals.tree", compact("referrals"));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $referrer)
    {
        $referrals = $referrer->load('directReferrals');

        return view("dashboard.referrals.direct-referrals", compact("referrals"));
    }

}

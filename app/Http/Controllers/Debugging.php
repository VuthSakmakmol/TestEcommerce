<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Debugging extends Controller
{
    public function debugRoles()
{
    $user = \App\Models\User::find(1); // Replace with the user ID
    dd($user->getRoleNames()); // Outputs the roles for the user
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Show the registration form with available roles.
     */
    public function show()
    {
        $roles = Role::all();
        return view('auth.register', ['roles' => $roles]);
    }
}

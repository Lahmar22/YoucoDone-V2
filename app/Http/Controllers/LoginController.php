<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
       
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        
        $loginAsUser = $this->loginUserByEmailPassword($email, $password);
        if ($loginAsUser) {
            return $loginAsUser;
        }

       
        $loginAsAdmin = $this->loginAdminByEmailPassword($email, $password);
        if ($loginAsAdmin) {
            return $loginAsAdmin;
        }

        
        return redirect()->back()->withErrors([
            'email' => 'Invalid email or password',
        ])->withInput($request->except('password'));
    }

   
    private function loginUserByEmailPassword($email, $password)
    {
        
        $user = User::where('email', $email)->first();

       
        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

       
        $role = $user->role;

        if (!$role) {
            return redirect()->back()->withErrors([
                'email' => 'User role not assigned',
            ])->withInput();
        }

        
        Auth::login($user);

       
        $roleDescription = strtolower($role->name);

        if ($roleDescription === 'client') {
            return redirect()->route('client.restaurants');
        } elseif ($roleDescription === 'restaurateur') {
            return redirect()->route('restaurateur.myRestaurant');
        }

        return redirect()->intended('welcome');
    }

    
    private function loginAdminByEmailPassword($email, $password)
    {
        
        $admin = Admin::where('email', $email)->first();

        
        if (!$admin || !Hash::check($password, $admin->password)) {
            return null;
        }

        
        Auth::guard('admin')->login($admin);
 
        return redirect()->route('admin.dashboard');
    }

    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Logout the admin guard and redirect to login.
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}


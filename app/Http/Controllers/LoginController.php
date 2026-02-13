<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        
        Auth::login($user);

       
        if ($user->hasRole('client')) {
            return redirect()->route('client.restaurants');
        } elseif ($user->hasRole('restaurateur')) {
            return redirect()->route('restaurateur.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
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


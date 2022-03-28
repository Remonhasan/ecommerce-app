<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{    
    /**
     * login Page
     *
     * @return void
     */
    public function loginForm()
    {
        return view('admin.login');
    }
    
    /**
     * login Check
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $loginCheck = $request->all();

        if(Auth::guard('admin')->attempt(['email'=>$loginCheck['email'],'password'=>$loginCheck['password']])){
            return redirect()->route('admin.dashboard')->with('error','Admin Login Successfully');
        }else{
            return redirect()->back()->with('error','Invalid Email or Password');
        }
    }
    
    /**
     * dashboard function
     *
     * @return void
     */
    public function dashboard()
    {
        return view('admin.index');
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login.form')->with('error','Admin Logout Successfully');
    }
}

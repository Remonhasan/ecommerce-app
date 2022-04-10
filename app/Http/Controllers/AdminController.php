<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return redirect()->route('admin.dashboard', app()->getLocale())->with('error','Admin Login Successfully');
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

    /**
     * Register Page as a Admin
     *
     * @return void
     */
    public function registerForm()
    {
       return view('admin.register');
    }

    /**
     * Register Logic
     *
     * @return void
     */
    public function register(Request $request)
    {
      Admin::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'created_at' => Carbon::now(),
      ]);
      return redirect()->route('login.form')->with('error','Admin Created Successfully!');
    }


}

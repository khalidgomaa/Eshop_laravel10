<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use function Laravel\Prompts\password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
   public function index(){
    return view('admin.login');
   }


   public function authenticate(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'email' => 'required|email',
           'password' => 'required|string',
       ]);
   
       if ($validator->passes()) {
           if (Auth::guard('admin')->attempt([
               'email' => $request->email,
               'password' => $request->password,
           ])) {
               $admin = auth()->guard('admin')->user();
               if ($admin->role == 2) {
                   return redirect()->route('admin.dashboard');
               } else {
                   auth()->guard('admin')->logout();
                   return redirect()->route('admin.login')->with('error', 'You do not have authorization.');
               }
           } else {
               return redirect()->route('admin.login')->with('error', 'Either email/password is invalid');
           }
       } else {
           // Validation failed, redirect back to the login page with errors and input data
           return redirect()->route('admin.login')
               ->withErrors($validator)
               ->withInput($request->only('email'));
       }
   }
   

}
